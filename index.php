<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo Selector</title>
    <link rel="stylesheet" href="/css/foundation.css" />
        <script src="/js/vendor/jquery.js"></script>
    <script src="/js/foundation.min.js"></script>
    <script src="/js/vendor/modernizr.js"></script>
     <link rel="stylesheet" type="text/css" href="/css/imgareaselect-default.css" />
    <script type="text/javascript" src="/js/jquery.imgareaselect.pack.js"></script>
  </head>
  <body>
    
    <div class="row">
      <div class="large-12 columns">
        <h1>Photo Selector</h1>
      </div>
    </div>
    
    <div class="row">
      <div class="large-12 columns">
      	<div class="panel">
	        <h3>Try to select a character</h3>
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
	        <div class="row">
	        	<div class="large-12 medium-12 columns">
                <div id="img_container">
      			<img id="photo" src="<?=$src?>">
                </div>
      			<div class="popup">
				      <label><b>Sex</b></label>
				      <input type="radio" name="sex" role="Male" checked="checked" value="1"><label for="pokemonRed">M</label>
				      <input type="radio" name="sex" role="Female" value="0"><label for="pokemonBlue">F</label>
				      <label><b>Age</b></label>
					  <input type="radio" name="age" role="0-18" checked="checked" value="0"><label for="pokemonRed">0-18</label>
				      <input type="radio" name="age" role="18-30" value="1"><label for="pokemonBlue">18-30</label>
				      <input type="radio" name="age" role="30+" value="2"><label for="pokemonBlue">30+</label>
				      <a id="svbtn" class="button tiny">Save</a>
      			</div>
    	</div>        
					</div>
      	</div>
      </div>
    </div>

 <form method="post" name="data" action="">
 <input type="hidden" name="date" value="<?=date('Y-m-d H:i:s')?>" />
 <input type="hidden" name="client_id" value="1" />
 <input type="hidden" name="src" value="<?=$src?>" />
    <div class="row">
      <div class="large-8 medium-8 columns">
        <h5>Here&rsquo;s your selections:</h5>
       
			<table id="table" style="width:100%">
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
      </div>     
      <div class="large-4 medium-4 columns">
			<h5>Send</h5>
			<p><input type="submit" class="small button" value="Save"><br/>           
      </div>
    </div>
	</form>    

    <script>
    var table = $("#table tbody");
    var popup = $(".popup");
    var photo = $('#photo');
    var coords;
    var sex = [];
    var age = [];

    $("#svbtn").click(function()
    {
      sex['val'] = $('input:checked[name="sex"]').val();
    	sex['text'] = $('input:checked[name="sex"]').attr("role");
      age['val'] = $('input:checked[name="age"]').val();
    	age['text'] = $('input:checked[name="age"]').attr("role");
	    	no = $('#table tr').length;
	    	table.append("<tr><td>"+no+"<input type='hidden' role='coords' name='person["+no+"][coords]' value="+coords+"><input type='hidden' name='person["+no+"][age]' value="+age['val']+"><input type='hidden' name='person["+no+"][sex]' value="+sex['val']+"></td><td>"+sex['text']+"</td><td>"+age['text']+"</td><td><span class='label alert'>x</span></td></tr>");
	    	var ias = photo.imgAreaSelect({ instance: true });
	    	ias.cancelSelection();
	    	popup.hide();
    });
      	$(document).foundation();

    $(document).on("mouseenter", "#table tbody tr", function(event){
        console.log($(this).find("input[role='coords']").val());
        var coords = new Array($(this).find("input[role='coords']").val());
        console.log(coords);
        $("<div id='border'></div>").css({position: 'absolute', top: coords[0]+'px', left: coords[3]+'px'}).insertAfter('#photo');
        //$("#img_container").append("<div class")
    });

	function showwindow (img, selection)
	{
		if ( (selection.width > 0) && (selection.height > 0 ) )
		{
		popup
			.css ({
				top: selection.y2*1 + 2,
				left: selection.x1*1 + 14
			})
			.show('slow');
		coords=[selection.x1, selection.x2, selection.y1, selection.y2];
		}
	}

  $(document).ready(function () {
      photo.imgAreaSelect({ onSelectEnd: showwindow });
  });
	</script>
  </body>
</html>
