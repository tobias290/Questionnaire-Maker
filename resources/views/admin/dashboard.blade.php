<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Questionnaire Maker Admin</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset("frontend/src/app/components/top-bar/top-bar.component.css") }}" rel="stylesheet">
    <link href="{{ asset("frontend/src/app/components/_public/questionnaire-list/questionnaire-list.component.css") }}" rel="stylesheet">
    <link href="{{ asset("frontend/src/app/components/questionnaire-list-item/questionnaire-list-item.component.css") }}" rel="stylesheet">
    <style>
        html, body {
            background: #E4E4E4;
            height: 100%;
            margin: 0;
            width: 100%;
        }

        .top-bar, .bar {
            background: #167BD3 !important;
        }

        .bar {
            width: 200px !important;
        }

        .questionnaire-list-item:hover {
            border-bottom: 5px solid #167BD3 !important;
        }

        .options > div:hover,  .options > div:hover > span {
            color: #167BD3 !important;
        }

    </style>
    <script>
        function lock(questionnaireId) {
            window.location.replace(`http://localhost:8000/admin/questionnaire/${questionnaireId}/lock`);
        }

        function unReport(questionnaireId) {
            window.location.replace(`http://localhost:8000/admin/questionnaire/${questionnaireId}/un-report`);
        }
    </script>
</head>
<body>
    @component("admin.topbar", ["title" => "Admin Dashboard"])
        <div class="top-bar-right">
            <button class="button inverse white"><a href="{{ route("adminSignOut") }}">Sign Out</a></button>
        </div>
    @endcomponent

    <div class="account-form-title">
        Reported Questionnaires
        <div class="bar"></div>
    </div>

    <div id="public-questionnaires-page-center">
        @foreach($reportedQuestionnaires as $reported)
            <div class="questionnaire-list-item">
                <div class="left">
                    <div class="title">{{ $reported->title }}</div> <!-- • -->
                    <div>
                        <strong>Created:</strong> {{ $reported->created_at }}
                    </div>
                </div>
                <div class="options">
                    <div class="delete-questionnaire" onclick="lock({{ $reported->id }})">
                        <i class="fas fa-lock"></i>
                        <span>Lock</span>
                    </div>
                    <div class="delete-questionnaire" onclick="unReport({{ $reported->id }})">
                        <i class="far fa-flag"></i>
                        <span>Un-report</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>