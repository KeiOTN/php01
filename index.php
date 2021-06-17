<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>PHP課題説明画面</title>
    <style>
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .title {
            margin-top: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid;
            border-color: black;
            border-radius: 5px;
            padding: 30px;
            width: 50%;
        }

        .text {
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="title">
            <div class="titile-inside">
                <h1>PHP制作課題として<br>アンケートを作成しました。</h1>
                <p>回答をお願いいたします。</p>
                <div class="text">
                    <button id="ok">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#ok').on('click', function() {
            location.href = "questionary_input.php";
        });
    </script>

</body>

</html>