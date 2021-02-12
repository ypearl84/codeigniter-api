<html>
<head>
    <title>Ad Campaign manager</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Ad Campaign manager</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">Ad Campaign manager</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <div>
                    <span>Search by partner id:</span> 
                    <input id="search_id" /> 
                    <button id="search_button">search</button>
                <div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Partner Id</th>
                            <th>Content</th>
                            <th>Duration</th> 
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody id="ad_body"> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="adModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="ad_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add ad campaign</h4>
                </div>
                <div class="modal-body">
                    <label>Enter Partner Id</label>
                    <input type="text" name="partner_id" id="partner_id" class="form-control" /> 
                    <br />
                    <label>Enter Contents</label>
                    <input type="text" name="ad_content" id="ad_content" class="form-control" /> 
                    <br />
                    <label>Enter Duration</label>
                    <input type="text" name="duration" id="duration" class="form-control" /> 
                    <br />
                </div>
                <div class="error"></div>
                <div class="modal-footer">  
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div> 

<script type="text/javascript" language="javascript" >
$(document).ready(function(){

    var list = <?php echo $data; ?>;
    $.each(list, function(key, value) {  
        $('#ad_body').append("<tr><td>"+value.partner_id+"</td><td>"+value.ad_content+"</td><td>"+value.end_time+"</td><td><button class='delete' data-id='"+value.index+"'>DELETE</button></td></tr>"); 
    });

    function fetch_all() {
        event.preventDefault();
        $.ajax({
            url: "http://localhost/ci-api/index.php/ad_api/all",
            method:"GET",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data) {    
                $("#ad_body").empty();
                $.each(data, function(key, value) {  
                    $('#ad_body').append("<tr><td>"+value.partner_id+"</td><td>"+value.ad_content+"</td><td>"+value.end_time+"</td><td><button class='delete' data-id='"+value.index+"'>DELETE</button></td></tr>"); 
                });
            }, 
        })
    }; 

    $('#add_button').click(function(){ 
        $('#ad_form')[0].reset(); 
        $('.error').html('');
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#adModal').modal('show');
        $('#adModal').show();
    });

    $('#search_button').click(function(){  
        event.preventDefault();

        var id = $('#search_id').val(); 
        $.ajax({
            url: "http://localhost/ci-api/index.php/ad_api/find/"+id,
            method:"GET", 
            dataType:"json",
            success:function(data) {    
                $("#ad_body").empty();
                console.log(data)
                $.each(data, function(key, value) {  
                    $('#ad_body').append("<tr><td>"+value.partner_id+"</td><td>"+value.ad_content+"</td><td>"+value.end_time+"</td><td><button class='delete' data-id='"+value.index+"'>DELETE</button></td></tr>"); 
                });
            }, 
        })
    });

    $(document).on('click', '.delete', function(event){ 
        event.preventDefault();
        $.ajax({
            url: "http://localhost/ci-api/index.php/ad_api/delete/"+$(this).data('id'),
            method:"DELETE", 
            dataType:"json",
            success:function(data) {     
                fetch_all();  
            }
        }) 
    });

    $(document).on('submit', '#ad_form', function(event){
        event.preventDefault();
        $.ajax({
            url: "http://localhost/ci-api/index.php/ad_api/insert",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data) {    
                if(data.status==201) {
                    $('#ad_form')[0].reset();
                    $('#adModal').modal('hide');
                    $('#adModal').hide();
                    $('.error').html(''); 
                    $('#success_message').html('<div class="alert alert-success">Data Inserted</div>'); 
                    fetch_all();

                }   
            },
            error:function(data) {        
                $('.error').html(data.responseJSON.message); 
            }
        })
    });
        
});
</script>