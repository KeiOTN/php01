<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>飲み会アンケート（入力画面）</title>
    <style>
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

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <a href="questionary_read.php" class="right">アンケート結果（一覧画面）</a>
    <div class="wrapper">
        <fieldset class="title">
            <legend>アンケート（入力画面）</legend>
            <h2>飲み会日程はいつがいいですか？</h2>
            <form method="post" action="questionary_create.php">
                回答者名: <input type="text" name="name"><br>
                候補日(複数可):<br>
                <input type="checkbox" name="date[]" value="6月26日(土)"> 2021年6月26日(土)<br>
                <input type="checkbox" name="date[]" value="6月27日(日)"> 2021年6月27日(日)<br>
                <input type="checkbox" name="date[]" value="6月28日(月)"> 2021年6月28日(月)<br>
                <input type="checkbox" name="date[]" value="6月29日(火)"> 2021年6月29日(火)<br>
                <input type="checkbox" name="date[]" value="欠席"> 欠席<br>
                コメントあれば: <input type="text" name="memo"><br><br>
                <div class="center">
                    <button id="button">送信</button>
                </div>
            </form>
        </fieldset>
    </div>
    <script>
        $('#button').on('click', function() {
            alert("アンケートを送信しました");
        });
    </script>

</body>

</html>