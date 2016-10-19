<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Travelator</title>

        <link rel="stylesheet" type="text/css" href="css/style.css">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    </head>

    <body>

    <div class="header row">
        <div class="col-sm-12">
            <h1>Travelator</h1>
        </div>
    </div>

    <div class="content row">
        <div class="planner col-sm-4">
            <div class="dest_panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Destinations</h3>
                </div>
                <div class="panel-body">
                    <ul class="dest_list list-group">
                        <li class="dest list-group-item">
                                Destination 1
                                <span class="badge pull-right">3 days</span>
                        </li>
                        <li class="dest list-group-item">
                                Destination 2
                                <span class="badge pull-right">2 days</span>
                        </li>
                        <li class="dest list-group-item">
                                Destination 3
                                <span class="badge pull-right">2 days</span>
                        </li>
                        <li class="dest list-group-item">
                                Destination 4
                                <span class="badge pull-right">5 days</span>
                        </li>
                    </ul>
                </div>
            </div>

            <form class="add_dest panel panel-default">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>

        </div>

        <div class="visualiser col-sm-8">
            <div id="map">
            </div>
        </div>
    </div>

    </body>
    
    <footer>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjBf13Qu1XH0l-KcykGEM8LshQFw1c4Bc"></script>

        <script type="text/javascript" src="js/functions.js"></script>
    </footer>
</html>
