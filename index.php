<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Crawler</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php include("loader.php");?>
    <div class="container mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Enter URL</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3 text-white">URL</span>
                </div>
                <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                <div id="urlMsg" class=""></div>
            </div>
            <button class="btn btn-success" id="btnSubmit">SUBMIT</button>
        </div>
        <table id="resulttable" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Links</th>
                    <th scope="col">Http Code</th>
                    <th scope="col">Internal Links</th>
                    <th scope="col">External Links</th>
                    <th scope="col">Images</th>
                    <th scope="col">Loading Time</th>
                    <th scope="col">Title</th>
                    <th scope="col">Title length</th>
                    <th scope="col">Word Count</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript">

        $("#btnSubmit").click(function() {
            if ($("#basic-url").val() == "") {
                $("#basic-url").addClass("is-invalid");
                $("#urlMsg").addClass("invalid-feedback");
                $("#urlMsg").html("Please add valid URL");
            } else {
                $("#basic-url").removeClass("is-invalid");
                $("#basic-url").addClass("is-valid");
                $("#urlMsg").removeClass("invalid-feedback");
                $("#urlMsg").addClass("valid-feedback");
                $("#urlMsg").html("Looks good!");
                $("#resulttable tbody").empty();
                gettingData($("#basic-url").val())
            }
        })

        function gettingData(url) {
            $.ajax({
                url: "./crawler.php",
                method: "GET",
                data: {
                    url: url
                },
                beforeSend: function() {
                    $('#loader').removeClass('hidden')
                },
                // contentType: "application/json",
                // dataType: "json",
                success: function(response) {
                    $("#resulttable tbody").empty();
                    $("#resulttable tbody").append(response);
                },
                complete: function() {
                    $('#loader').addClass('hidden')
                    $('#btnSubmit').prop('disabled', false);
                },
                error: function(jqXHR, exception) {
                    console.log("Error", exception);
                }
            });

        }
    </script>
</body>
</body>

</html>