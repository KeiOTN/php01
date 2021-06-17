<?php
$str = ''; // 出力用の空の文字列
$array = []; // 空の配列
$file = fopen('data/questionary.csv', 'r'); // ファイルを開く(読み取り専用) 
flock($file, LOCK_EX); // ファイルをロック
if ($file) {
    while ($line = fgets($file)) { // fgets()で1行ずつ取得→$lineに格納
        $str .= "<tr><td>{$line}</td></tr>"; // 取得したデータを$strに入れる 
        array_push($array, $line); // 取得したデータを配列$arrayに入れる 
    }
    // 取得したデータを$strに入れる 
}
flock($file, LOCK_UN); // ロック解除 
fclose($file); // ファイル閉じる

// var_dump($array);// OK

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <title>アンケート結果</title>
    <style>
        /* chart.js */
        #ex_chart {
            max-width: 100%;
            max-height: 480px;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .title {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border: 1px solid;
            border-color: black;
            border-radius: 5px;
            padding: 30px;
            width: 50%;
        }

        .legend {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .box1,
        .box2 {
            width: 100%;
            padding: 30px;
        }
    </style>

</head>

<body>
    <a href="questionary_input.php" class="right">アンケート入力画面へ</a>
    <div class="wrapper">
        <fieldset class="title">
            <legend class="legend">飲み会アンケート結果</legend>
            <div class="box1">
                <canvas id="ex_chart"></canvas>
            </div>
            <div class="box2">
                <table>
                    <thead>
                        <tr>
                            <th> <?= $str ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </fieldset>
    </div>



    <script>
        // phpからJSへ値を変換する
        const array = <?= json_encode($array) ?> // json形式にしないと互換できない
        // console.log(array);

        const greatArray = array.map(x => {
            return {
                'name': x.split(' ')[0],
                'date': x.split(' ')[1].split('、'),
                'memo': x.split(' ')[2].split('\n').join(''),
            }
        })
        // console.log(greatArray[0].name);

        // 別々にする
        // 名前の配列
        const name = [];
        for (let i = 0; i < greatArray.length; i++) {
            let nameList = greatArray[i].name;
            // console.log(nameList);
            name.push(nameList);
        }
        // console.log(name);

        // コメント配列
        const memo = [];
        for (let i = 0; i < greatArray.length; i++) {
            let memoList = greatArray[i].memo;
            // console.log(memoList);
            memo.push(memoList);
        }
        // console.log(memo);

        // 日にち候補の配列
        const date = [];
        for (let i = 0; i < greatArray.length; i++) {
            let dateList = greatArray[i].date;
            // console.log(dateList); // 配列の形になっている（日付選択個数により要素数に差あり）
            for (let j = 0; j < dateList.length; j++) {
                let dateListDetail = dateList[j].split(',');
                // console.log(dateListDetail); // 日付バラバラでたー！！！
                // let dateListDetail_DelitedBlackets = dateListDetail.substr(1, -2)// 違うな
                // date.push(dateListDetail); // でも[]付き？なぜ？↑.substr(1, -2)してみたけどダメ
                // forもういっかいしてみる？
                for (let k = 0; k < dateListDetail.length; k++) {
                    let dateListDetail_delitedBlackets = dateListDetail[k];
                    // console.log(dateListDetail_delitedBlackets);// []無しになった！
                    date.push(dateListDetail_delitedBlackets);
                }
            }
        }
        // console.log(date);

        // chart.jsのラベル用に＊月＊日に変換→このタイミングじゃない→そもそも最初から＊月＊日でval渡したらいいんじゃ？
        // const dateLabel = [];
        // for (let i = 0; i < date.length; i++) {
        //     // console.log(String(date[0]).substr(4, 4));
        //     let dateDevided = date[i].substr(4, 2) + '月' + date[i].substr(6, 2) + '日';
        //     console.log(dateDevided);
        // }

        // 日付の集計をする
        const count = {};
        for (var i = 0; i < date.length; i++) {
            var elm = date[i];
            count[elm] = (count[elm] || 0) + 1;
        }
        // ということはこのへんも変わるのか
        // console.log(count); // 例：{20210626: 3, 20210627: 5, 20210628: 4, 20210629: 1}
        // console.log(Object.keys(count));  // 例：["20210626", "20210627", "20210628", "20210629"]
        // console.log(Object.values(count));// 例：[3, 6, 4, 1]

        // ここいらなくなる
        // chart.jsのラベル用に＊月＊日に変換
        // var dateValues = Object.keys(count);
        // console.log(dateValues); // 例：["20210626", "20210627", "20210628", "20210629"]
        // const dataLabel = [];
        // for (let i = 0; i < dateValues.length; i++) {
        //     console.log(dateValues);
        //例：["20210626", "20210627", "20210628", "20210629"]["20210626", "20210627", "20210628", "20210629"]["20210626", "20210627", "20210628", "20210629"]["20210626", "20210627", "20210628", "20210629"]
        // ↑あわわ、4つでた
        // let dateReConstruct = date[i].substr(4, 2) + '月' + date[i].substr(6, 2) + '日';
        // console.log(dateReConstruct);
        // }

        // valを*月＊日に直してconsole.logやり直し
        // console.log(count); // 例：{6月26日(土): 3, 6月27日(日): 3, 6月28日(月): 5, 6月29日(火): 3}
        // ※入力した順にオブジェクト作成される模様。日付順or投票数順にしたいなー
        // 値順にソート
        // count.sort(function(a, b) {
        //     return a.value - b.value;
        // });
        // console.log(count);
        // console.log(Object.keys(count)); // 例： ["6月26日(土)", "6月27日(日)", "6月28日(月)", "6月29日(火)"]
        // console.log(Object.values(count)); // 例： [3, 3, 5, 3]
        // OKOK

        const dateKeys = Object.keys(count);
        // console.log(dateKeys); // 例：["6月26日(土)", "6月27日(日)", "6月28日(月)", "6月29日(火)"]
        const dateValues = Object.values(count);
        // console.log(dateValues);// 例： [3, 3, 5, 3]


        const ctx = document.getElementById('ex_chart');

        const data = {
            // labels: ["平成26年", "平成27年", "平成28年", "平成29年", "平成30年"],// 例
            labels: dateKeys,
            datasets: [{
                label: '投票数',
                // data: [880, 740, 900, 520, 930],// 例
                data: dateValues,
                backgroundColor: 'rgba(255, 100, 100, 1)'
            }]
        };

        const options = {
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                        stepSize: 1,
                    }
                }]
            }
        };

        const ex_chart = new Chart(ctx, {
            type: 'horizontalBar',
            data: data,
            options: options
        });
    </script>
</body>

</html>