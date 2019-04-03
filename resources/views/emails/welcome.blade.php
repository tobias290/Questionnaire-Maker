<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Questionnaire Maker</title>
    <style>
        * {
            font-family: helvetica, arial, sans-serif
        }

        html, body {
            background: #E4E4E4;
            height: 100%;
            margin: 0;
            width: 100%;
        }

        .top-bar {
            align-items: center;
            background: #16D36B;
            display: flex;
            height: 70px;
            justify-content: space-between;
            width: 100%;

        }

        .top-bar > .top-bar-left {
            align-items: center;
            color: #FFF;
            display: flex;
            font-size: 26px;
            font-style: italic;
            font-weight: bold;
            height: 70px;
            line-height: 70px;
            margin-left: 15px;
            width: fit-content;
        }

        .background {
            background: #E4E4E4;
            height: 500px;
            overflow: auto;
            width: 100%;
        }

        .centre-box {
            background: #FFF;
            box-shadow: 0 5px 5px rgba(0, 0, 0, .16);
            left: 0;
            margin: 20px auto 20px auto;
            right: 0;
        }

        #landing-page-center {
            position: absolute;
            display: flex;
            flex-direction: column;
            font-weight: bold;
            height: 200px;
            justify-content: space-evenly;
            text-align: center;
            margin-top: 125px;
            width: 60%;
        }

        #landing-page-center > div {
            color: #707070;
            font-size: 50px;
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="top-bar-left">Questionnaire Maker</div>
    </div>
    <div class="background">
        <div id="landing-page-center" class="centre-box">
            <div>Thank You {{ $name }} for signing up with us!</div>
        </div>
    </div>
</body>
</html>
