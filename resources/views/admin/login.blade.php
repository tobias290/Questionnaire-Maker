<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Questionnaire Maker Admin</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset("frontend/src/app/components/top-bar/top-bar.component.css") }}" rel="stylesheet">
    <link href="{{ asset("frontend/src/app/components/login/login.component.css") }}" rel="stylesheet">
    <style>
        html, body {
            background: #E4E4E4;
            height: 100%;
            margin: 0;
            width: 100%;
        }

        .top-bar, .bar, .button, .app-input-label-icon {
            background: #167BD3 !important;
        }

        .button:hover {
            background: #136EBD !important;
        }
    </style>
</head>
<body>
    @component("admin.topbar", ["title" => "Admin Login"])
    @endcomponent

    <div class="account-form-title">
        Admin Log In
        <div class="bar"></div>
    </div>

    <div id="login-page-center" class="centre-box">
        <form id="login" action="{{ route("adminLogin") }}" method="post">
            {{ csrf_field() }}

            <div class="app-input-container">
                <label class="app-input-label-icon">
                    <i class="fas fa-user"></i>
                </label>
                <input
                    class="app-input"
                    name="username"
                    type="text"
                    placeholder="Username"
                >
            </div>

            <div class="app-input-container">
                <label class="app-input-label-icon">
                    <i class="fas fa-user"></i>
                </label>
                <input
                    class="app-input"
                    name="password"
                    type="password"
                    placeholder="Password"
                >
            </div>

            <input class="button normal green large" type="submit" value="Log In">
        </form>
    </div>

    @if ($error)
        Incorrect login details
    @endif
</body>
</html>