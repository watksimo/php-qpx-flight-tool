<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sortable Test</title>
        <style>
            h1 { text-align: center; size: 2em; }
            .visualiser { height: 400px; text-align: center; }
            .dest-list { width: 95%; display: inline-block; }
            .content { text-align: center; }
            #map {height: 95%; width: 95%; display: inline-block; }
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });
        }
        $( function() {
            $( ".dest-list" ).sortable();
            $( ".dest-list" ).disableSelection();
        });
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjBf13Qu1XH0l-KcykGEM8LshQFw1c4Bc&callback=initMap"
        async defer></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </head>

    <body>

    <div class="header row">
        <div class="col-sm-12">
            <h1>Travelator</h1>
        </div>
    </div>

    <div class="content row">
        <div class="planner col-sm-4">

            <ul class="dest-list list-group">
                <li class="dest list-group-item">
                        Destination 1
                </li>
                <li class="dest list-group-item">
                        Destination 2
                </li>
            </ul>
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

    <div class="footer row">

    </div>

    </body>
</html>
