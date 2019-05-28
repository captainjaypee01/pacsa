
var protocol = window.location.protocol + "//";
var host = window.location.host;
var path = "/pacsa"; 
var app_url = protocol + host + path;
console.log(app_url);

    $(document).ready(function() {
       
        $("#school").keyup(function(e){
            var search = $(this).val();
            fetch_schools(search);
        });
        function fetch_schools(search = null){
            // console.log()
            $.ajax({
            
                type: "POST",
                url: app_url + "/frontend/fetch_schools",
                data: { search : search },
                dataType:"json",    
                success: function(response) {
                    var schools = response.schools;
                    $("#school-list").html(response.html);
                    console.log(response);
                },
                error: function(response){
                    console.log('hey');
                    console.log(response);
                }
            });
        }

    
            fetch_schools();
    });