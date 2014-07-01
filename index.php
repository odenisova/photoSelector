<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo Selector</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/css/main.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>    
    <link rel="stylesheet" type="text/css" href="/css/imgareaselect-default.css" />
    <script type="text/javascript" src="/js/jquery.imgareaselect.pack.js"></script>
    <link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <header class="header">
    <div class="container">
	    <div class="row">
	      <div class="col-xs-12 col-md-12">
	       Photo Selector
	      </div>
	    </div>
	</div>
    </header>


	        <?
          include_once($_SERVER['DOCUMENT_ROOT']."/inc/core.php");      
    			if ( (!empty($_POST)) && (is_array($_POST)))
    			{
    				$persons = new persons;
    				$persons->addNew($_POST);
                    photos::removePhoto($_POST['src']);
    			}

          $src =  photos::getPhoto(); 

	        ?>
	    <div class="container">
	    <div class="row">
	    <div class="col-xs-8 col-md-8">
            <div id="img_container">
      		<img id="photo" width="800" src="<?=$src['res']?>">
            </div>
      		<div class="popup">
			      <span>Sex</span>
		<div class="btn-group" data-toggle="buttons">
		  <label class="btn btn-primary active btn-female">
		    <input type="radio" name="sex" role="F" value="0" checked="checked"> F </label>
		  <label class="btn btn-primary  btn-male">
		    <input type="radio" name="sex" role="M" value="1"> M </label>
		</div>
			     <br/> <span>Age</span>
		<div class="btn-group" data-toggle="buttons">
		  <label class="btn btn-primary active btn-0">
		    <input type="radio" name="age"  role="0-18" value="0" checked="checked"> 0-18 </label>
		  <label class="btn btn-primary btn-18">
		    <input type="radio" name="age" role="18-30" value="1"> 18-30 </label>
		  <label class="btn btn-primary btn-30">
		    <input type="radio" name="age" role="30+" value="2"> 30+ </label>
		</div>			<br/>
			      <a id="svbtn" class="btn btn-default btn-xs">Save</a>
      		</div>
    	</div>  
    	<div class="col-xs-3 col-md-3 tablecol ">
    		 <form method="post" name="data" action="">
			 <input type="hidden" name="date" value="<?=date('Y-m-d H:i:s')?>" />
			 <?$client_id = explode('_', $src['name'])?>
			 <input type="hidden" name="client_id" value="<?=$client_id[0]?>" />
			 <input type="hidden" name="IP" value="<?=$_SERVER['REMOTE_ADDR']?>" />
			 <input type="hidden" name="src" value="<?=$src['res']?>" />
			<p class="tablehead clearfix"><span><?=$src['name']?></span> <input type="submit" class="btn btn-success" value="NEXT"></p>  
			    	<table id="table" class="table">
						  <thead>
						    <tr>
						      <th style="width: 20px">№</th>
						      <th>Sex</th>
						      <th>Age</th>
						      <th style="width: 20px"></th>
						    </tr>
						  </thead>
						  <tbody>
						  </tbody>
					</table>
			</form>  
    	</div>     
		</div>
		</div>
     
  

  

    <script>
    var table = $("#table tbody");
    var popup = $(".popup");
    var photo = $('#photo');
    var coords;
    var size;
    var sex = [];
    var age = [];

    $("#svbtn").click(function()
    {
    	sex['val'] = $('input:checked[name="sex"]').val();
    	sex['text'] = $('input:checked[name="sex"]').attr("role");
    	age['val'] = $('input:checked[name="age"]').val();
    	age['text'] = $('input:checked[name="age"]').attr("role");
	    no = $('#table tr').length;
	    table.append("<tr><td>"+no+"<input type='hidden' name='no' value="+no+" /><input type='hidden' role='coords' name='person["+no+"][coords]' value="+coords+" /><input type='hidden' name='person["+no+"][age]' value="+age['val']+" /><input type='hidden' name='person["+no+"][sex]' value="+sex['val']+" /></td><td>"+sex['text']+"</td><td>"+age['text']+"</td><td><span class='label label-danger'>Х</span></td></tr>");
	    var ias = photo.imgAreaSelect({ instance: true });
	    ias.cancelSelection();
	    popup.hide();
	     $("<div class='border' role='"+no+"'>"+sex['text']+"<br />"+age['text']+"</div>").css({
	     									position: 'absolute', 
	     									top: coords[2]+(coords[5]/2)-29+'px', //y1
	     									left: coords[0]+(coords[4]/2)-18+'px', //x1
	     								}).attr("role", no).insertAfter('#photo');
    });

    $(document).on("mouseenter", "#table tbody tr", function(event){       
        no = $(this).find("input[name='no']").val();
    	//$(".border[role="+no+"]").css("border-color", "#2285a2");
    });

    $(document).on("mouseleave", "#table tbody tr", function(event){       
        no = $(this).find("input[name='no']").val();
    	//$(".border[role="+no+"]").css("border-color", "white");
    });    

    $(document).on("click", ".label", function(event){

        no = $(this).parents("tr").find("input[name='no']").val(); 
    	$(".border[role="+no+"]").remove();
    	no = $(this).parents("tr").remove();
    });    

	function showwindow (img, selection)
	{
		popup
			.css ({
				top: selection.y2*1 + 2,
				left: selection.x1*1 + 14
			})
			.show('fast');
		coords=[selection.x1, selection.x2, selection.y1, selection.y2, selection.width, selection.height];
	}

  $(document).ready(function () {
      photo.imgAreaSelect({ onSelectEnd: showwindow });
  });
	</script>
  </body>
</html>
