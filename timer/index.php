<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
	
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.5.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.js"></script>
	<script type="text/javascript" src="./jquery.stopwatch.js"></script>

	
	<script type="text/javascript">
	
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <info@pegasi.de> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Frank Fitzke
 * ----------------------------------------------------------------------------
 *
 * THIS PLUGIN IS DELIVERD ON A PAY WHAT YOU WHANT BASIS. IF THE PLUGIN WAS USEFUL TO YOU, PLEASE CONSIDER BUYING THE PLUGIN HERE :
 * http://www.pegasi.de
 *
 * Date: October 15, 2016
 */


		(function($) {
	
			$.fn.inlineEdit = function(options) {
			
				// define some options with sensible default values
				// - hoverClass: the css classname for the hover style
				options = $.extend({
					hoverClass: 'hover'
				}, options);
			
				return $.each(this, function() {
			
					// define self container
					var self = $(this);
			
					// create a value property to keep track of current value
					self.value = self.text();
			
					// bind the click event to the current element, in this example it's span.editable
					self.bind('dblclick', function() {

						self.value = self.text();

						self
							// populate current element with an input element and add the current value to it
							.html('<input type="text" id="name" class="name" value="'+ self.value +'">')		
							// select this newly created input element
							.find('input')
								// bind the blur event and make it save back the value to the original span area
								// there by replacing our dynamically generated input element
								.bind('blur', function(event) {
									self.value = $(this).val();
									self.text(self.value);
								})
								// give the newly created input element focus
								.focus();
								
					})
					// on hover add hoverClass, on rollout remove hoverClass
					.hover(
						function(){
							self.addClass(options.hoverClass);
						},
						function(){
							self.removeClass(options.hoverClass);
						}
					);
				});
			}
			
		})(jQuery);
			
    </script>
	
	



	<style type="text/css">
		#original_items, #cloned_items {
			list-style: none;
		}
		
		#original_items li {
			float: left;
			position: relative;
			z-index: 5;
		}
		
/*
		ul li {
			margin: 3px 3px 3px 0;
			padding: 1px;
			width: 100px;
			height: 90px;
			font-size: 4em;
			text-align: center;
			border: solid 1px #333;
			background-color: #eaa10e;
		}
*/
		
		#cloned_items li {
			position: absolute;
			z-index: 1;
		}
		
		#sortable {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}
		
		#sortable li{ 
			margin: 3px 3px 3px 0;
			padding: 3px 8px 0px 8px;
			float: left; 
			min-width: 100px;
			min-height: 90px;
/*			font-size: 4em; */
			text-align: center;
			border: solid 1px #333;
		 }
		
		#master {
			list-style-type: none;
			width:210px;
			margin: 0;
			padding: 0;
		}
		
		
		
		.li_template{ 
			margin: 3px 3px 3px 0;
			padding: 1px;
			min-width: 100px;
			max-width: 300px;
			min-height: 90px;
/*			font-size: 4em;   */
			text-align: center;
			border: solid 1px #333;
		 }
		
		#master li{ 
			margin: 3px 3px 3px 0;
			padding: 1px;
			min-width: 100px;
			min-height: 90px;
/*			font-size: 4em;   */
			text-align: center;
			border: solid 1px #333;
		 }
		
		div.timerbox {
			border:1px #666666 solid;
			width:190px;
			height:50px;
			line-height:50px;
			font-size:36px;
			font-family:"Courier New", Courier, monospace;
			text-align:center;
			margin-top: 5px;
			margin-right: auto;
			margin-bottom: 5px;
			margin-left: auto;
		}

		div.removebox {
			font-size:14px;
			float:right;
			cursor: pointer;
			margin-top: -3px;
			margin-right: -5px;
		}

		div.userbox {
			border:1px #666666 solid;
			width: 350px;
			float: left;
			margin: 5px;
			padding: 3px;
		}

		.name {
			font-size: 36px;
		}


		#wortmeldung {
			width:20px;
			height:20px;
			background-color:#CCFFCC;
			color:#CCCCCC;
			padding: 8px 3px 1px 3px;
			font-size:10px;
		}

		#wortmeldung:hover{
			background-color: #993300;
		}

		#wortmeldung.blue {
			background-color: #0066FF;
		}

		
		.buttons {
			background-color: #4CAF50;
			border: none;
			color: white;
			padding: 7px 13px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 13px;
			margin: 4px 2px;
			cursor: pointer;
		}

	</style>



	<script type='text/javascript'>//<![CDATA[
	
		$eventsession = "556666";
		var maxsec = new Date(Date.parse("January 1, 2030"));
	
		function sleep (time) {
			return new Promise((resolve) => setTimeout(resolve, time));
		}

	
		function createtopbox(index) {
			var c = $('.top_template').clone(true);
			console.log(c);
			c.show();
			c.attr('class','userbox');
			c.attr('id','index'+index);
			c.children(':text').attr('name','input'+ (index) );
//				c.find('.timerbox').stopwatch().stopwatch('start');
			
			c.find('.timerbox').stopwatch().click(function(){ 

				var result = $(this).stopwatch('status');
                console.log('active:' + JSON.stringify(result));
								
				if ( !result ) {
					callevent({	command: 'toptimerstop', time:'0' });

				} else {
					callevent({	command: 'toptimerstart', time:'0' });
				
				}

            });

			c.find('#startstop').click(function(){ 
				var c = $(this).parent();
				var timerbox = c.find('.timerbox');
				var result = timerbox.stopwatch('toggle2');
				
                console.log('active:' + JSON.stringify(result));
								
				if ( !result ) {
					callevent({	command: 'toptimerstop', time:'0' });

				} else {
					callevent({	command: 'toptimerstart', time:'0' });
				
				}

            });

			c.find('#reset').click(function(){
/*
				var c = $(this).parent();
				var timerbox = c.find('.timerbox');
				timerbox.stopwatch('reset');
				timerbox.stopwatch('stop');
				timerbox.text('00:00:00');
*/
				callevent({	command: 'toptimerreset', time: '0' });

/*
				$('#sortable .userbox').each( function () {
					$(this).find('.timerbox').stopwatch('reset');
					$(this).find('.timerbox').text('00:00:00');
					
				});
*/
/*				sleep(500);
				$('#sortable .userbox').each( function () {
					$(this).find('.timerbox').stopwatch('stop');
				});
*/
			});

			return c;
		}
	
		function createuserbox(index) {
			var c = $('.li_template').clone(true);
			console.log(c);
			c.show();
			c.attr('class','userbox');
			c.attr('id','index'+index);
			c.children(':text').attr('name','input'+ (index) );
			c.find('#name').inlineEdit();
			c.find('#wortmeldung').attr('value',maxsec.getTime());

			c.find('.timerbox').stopwatch().click(function(){ 
				c.siblings().each( function () {
					$(this).find('.timerbox').stopwatch().stopwatch('stop');
				});

				var result = $(this).stopwatch('toggle2');
                console.log('active:' + result);
				
				var msec = new Date(Date.parse("January 1, 2030"));
				c.find('#wortmeldung').attr('value',msec.getTime());

				if ( result ) {
					c.find('#wortmeldung').removeClass("blue");
					$('#index0').find('.timerbox').stopwatch().stopwatch('start');

				}
				sort();
				
            });
			
			c.find('#startstop').click(function(){
				$result = c.find('.timerbox').stopwatch();
				console.log('debug:' + $(this).parent().find('.timerbox').stopwatch('getActive'));
				
				$element = $(this).parent();
				
				$time = $element.find('.timerbox').stopwatch().stopwatch('getTime');
				if ($element.find('.timerbox').stopwatch().stopwatch('getActive')){
					callevent({	command: 'timerstop',  username: $element.find('#name').text(), value: $time });

				} else {
					callevent({	command: 'timerstart', username: $element.find('#name').text(), value: $time });

				}
				
            });
			
			c.find('#wortmeldung').click(function () {
//				userboxwordrequest($(this).parent(), !$(this).hasClass('blue') ,true);
				
				var nowsec = new Date();
				if ($(this).hasClass('blue')) {
					c.find('#wortmeldung').attr('value',maxsec.getTime());
					callevent({	command: 'wordrequestoff', username: c.find('#name').text(), time: maxsec.getTime() });
				} else {
					c.find('#wortmeldung').attr('value',nowsec.getTime());
					callevent({	command: 'wordrequeston', username: c.find('#name').text(), time: c.find('#wortmeldung').attr('value') });
				}
	
			});

			c.find('.remove').click(function(){
				var c = $(this).parent().parent();
				callevent({	command: 'deluser', username: c.find('#name').text() });
			});

			return c;
		}
	

		function userboxtimer($element, $onoff = false, $local = false) {
			var timerbox = $element.find('.timerbox');
			var result;
			if ($onoff){
				$element.siblings().each( function () {
					$(this).find('.timerbox').stopwatch().stopwatch('stop');
	//					console.log($(this));
				});
			
				result = timerbox.stopwatch('start');

				$element.find('#wortmeldung').removeClass("blue");
				$('#index0').find('.timerbox').stopwatch().stopwatch('start');

				$element.find('#wortmeldung').attr('value',maxsec.getTime());

				if ($local == true) callevent({	command: 'timerstart', username: $element.find('#name').text() });
	

			} else {
				result = timerbox.stopwatch('stop');

				if ($local == true) callevent({	command: 'timerstop',   username: $element.find('#name').text() });
			}
			console.log('toogle2 active:' + result);
			

			sort();

		}

		function userboxwordrequest($element, $onoff, $local = false) {
			$that = $element.find('#wortmeldung');
			var nowsec = new Date();
			if ($onoff == true) {
				$that.addClass("blue");
				$that.attr('value',nowsec.getTime());
			
			} else {
				$that.removeClass("blue");
				$that.attr('value',maxsec.getTime());
			
			}
				
			sort();
		
		}
	
		function sort() {
			var sortableList = $('#sortable');
			var listitems = $('li', sortableList);

			listitems.sort(function (a, b) {
				var result = -1;
//					if 
				
//				return   ( $(a).find('#name').text().toUpperCase() > $(b).find('#name').text().toUpperCase() ) ? 1 :( $(a).find('.wortmeldung').attr('value') > $(b).find('.wortmeldung').attr('value') ) ? 1 : -1;
				//console.log('sort_a:' + $(a).find('.timerbox').stopwatch().stopwatch('getActive') );			
				if        ( ( $(a).find('.timerbox').stopwatch().stopwatch('getActive') == false ) && ( $(b).find('.timerbox').stopwatch().stopwatch('getActive') == true ) ) {	
					return 1;

				} else if ( ( $(a).find('.timerbox').stopwatch().stopwatch('getActive') == true ) &&  ( $(b).find('.timerbox').stopwatch().stopwatch('getActive') == false ) ) {
					return -1;

				}

				if        ( $(a).find('#wortmeldung').attr('value') > $(b).find('#wortmeldung').attr('value') ) {
					return 1;

				} else if ( $(a).find('#wortmeldung').attr('value') < $(b).find('#wortmeldung').attr('value') ) {
					return -1;

				}

				if        ( $(a).find('#name').text().toUpperCase() > $(b).find('#name').text().toUpperCase() ) {
					return 1;

				} else if ( $(a).find('#name').text().toUpperCase() < $(b).find('#name').text().toUpperCase() ) {
					return -1;

				}
				return 0
				
				
/*				
				if (( $(a).find('.wortmeldung').attr('value') > $(b).find('.wortmeldung').attr('value') ) || ( $(a).find('#name').text().toUpperCase() > $(b).find('#name').text().toUpperCase() ) ) {
					return 1;
				}
				return -1
*/

//					return ;
//				return ( $(a).find('.wortmeldung').attr('value') > $(b).find('.wortmeldung').attr('value') )  ? 1 : -1;
//					return ( $(a).find('#name').text().toUpperCase() > $(b).find('#name').text().toUpperCase() )  ? 1 : -1;
			});

			sortableList.append(listitems);

		}


		function confreset() {
	
			index = 0;
			var file = "config.php";
			var rawFile = new XMLHttpRequest();
			rawFile.overrideMimeType("application/json");
			rawFile.open("GET", file, false);
			rawFile.onreadystatechange = function() {
				if (rawFile.readyState === 4 && rawFile.status == "200") {
		//            callback(rawFile.responseText);
					
					var data = JSON.parse(rawFile.responseText);
					console.log(data);

					for (var k in data.users) {
					
						data_tmp = data.users[k];
						console.log(data_tmp);
							
						var c_element = createuserbox(++index);
						c_element.find('.name').text(data_tmp.name);

						if (parseInt(data_tmp.wordrequest) != 0) {
							c_element.find('#wortmeldung').addClass("blue");
							c_element.find('#wortmeldung').attr('value', parseInt(data_tmp.wordrequest));
						}

						c_element.find('.timerbox').stopwatch().stopwatch('setTime',data_tmp.time); 

						if (data_tmp.status == 'start') {
							c_element.find('.timerbox').stopwatch().stopwatch('start'); 
						} else {
							c_element.find('.timerbox').stopwatch().stopwatch('stop'); 
						}
						$('#sortable').append(c_element);
						
						
					}
					
				}
			}
			rawFile.send(null);
		
		}

		$(window).load(function(){
			var index = 0; 

			$(".li_template").css("display","none");
			$(".top_template").css("display","none");


			$( "#sortable" ).sortable({
				create: function (event, ui) {
					sort();
				},
				opacity: 0.5,
				stop: function(event, ui) {
					console.log("stop");
				}
			}); 
			
			$('#btnAdd').click(function() {
				var name = $('#textAdd').val();
				callevent({	command: 'adduser', username: name });
			});
	
			var c_element = createtopbox(0);
			c_element.find('.name').text("TOP"); 
			$('#master').append(c_element);
	
			confreset();
	
			sort();
	

			$('#message').submit(function(e){
				e.preventDefault();
			});
		
			if(typeof(EventSource)!=="undefined") {
				var source1 = new EventSource('./index_data.php');
				var lasttimestamp;
			
				source1.addEventListener('user',function(e){
					$('#latest').html('Current User: '+e.data);
				},false);
			
				source1.addEventListener('command',function(e){
					console.log('Command: '+e.data);
					$('#latest').html('Command: '+e.data);
					var data = $.parseJSON(e.data);
					if (data['command'] == 'wordrequeston') {
						$('#sortable .userbox').each( function () {
   		 					if( $(this).find('#name').text() == data['username'] ) {
								userboxwordrequest($(this), true, false);

							}
							
						});

					} else if (data['command'] == 'wordrequestoff') {
						$('#sortable .userbox').each(function(){
   		 					if( $(this).find('#name').text() == data['username'] ) {
								userboxwordrequest($(this), false, false);

							}

						});
						
					} else if (data['command'] == 'adduser') {
					 	adduser = true;
						$('#sortable .userbox').each(function(){
   		 					if( $(this).find('#name').text() == data['username'] ) {
								adduser = false;
							}
						});
					 	if (adduser) {
						 	var c_element = createuserbox(1);
							c_element.find('.name').text(data['username']);
							$('#sortable').append(c_element);
							sort();
						}
						
					} else if (data['command'] == 'deluser') {
						adduser = true;
						$('#sortable .userbox').each(function(){
   		 					if( $(this).find('#name').text() == data['username'] ) {
								$(this).remove();
							}
						});
						
					} else if (data['command'] == 'timerstart') {
						$('#sortable .userbox').each(function(){
   		 					if( $(this).find('#name').text() == data['username'] ) {
								userboxtimer($(this), true, false);

							}

						});
						
					} else if (data['command'] == 'timerstop') {
						$('#sortable .userbox').each(function(){
   		 					if( $(this).find('#name').text() == data['username'] ) {
								userboxtimer($(this), false, false);

							}

						});
						
					} else if (data['command'] == 'toptimerstart') {
						$('#index0').find('.timerbox').stopwatch().stopwatch('start');
						
					} else if (data['command'] == 'toptimerstop') {
						$('#index0').find('.timerbox').stopwatch().stopwatch('stop');

						$('#sortable .userbox').each( function () {
							$(this).find('.timerbox').stopwatch().stopwatch('stop');
						});

					} else if (data['command'] == 'toptimerreset') {
						$('#index0').find('.timerbox').stopwatch().stopwatch('stop');
						$('#index0').find('.timerbox').stopwatch().stopwatch('setTime',0); 
						$('#sortable .userbox').each( function () {
							$(this).find('.timerbox').stopwatch().stopwatch('stop');
							$(this).find('.timerbox').stopwatch().stopwatch('setTime',0); 
						});
						
					}	

					
				},false);
			
				source1.addEventListener('message',function(e){
					var data = $.parseJSON(e.data);
					$('#lines').prepend($('<blockquote>',{text:data.msg}).append($('<small>',{text:'By '+data.user})));
				},false);
			
			
				source1.onerror = function(e){
				
					e = e || event, msg = '';
					
					switch( e.target.readyState ){
						// if reconnecting
						case EventSource.CONNECTING:
							msg = 'Reconnecting…';
							break;
						// if error was fatal
						case EventSource.CLOSED:
							msg = 'Connection failed. Will not retry.';
							break;
					}
					console.log(msg);
				
				}
			} else {
				document.getElementById("result").innerHTML="Sorry, your browser does not support server-sent events...";
			}

		});//]]> 

		function callevent($data){
			$data['session'] = $eventsession;
			$.ajax({
				url:'./index_command.php',
				type:'POST',
				data:$data,
				success:$.noop
			});


/*
		$('#message').submit(function(e){
			e.preventDefault();
			$.ajax({
				url:'./recv.php',
				type:'POST',
				data:{
					message: $('#msg').val(),
					user: $('#user').val()
				},
				success:$.noop
			});
		});
*/
			
		}

	</script>

  
</head>

<body>

	<h2>Wortuhr / Redeliste der NRW-Piratenfraktion</h2>

	<ul id="master">
	</ul>  
	



	<div>
        Neuer Nutzer:<input type="text" id="textAdd" value="-- name eingeben --" /><input type="button" id="btnAdd" value="Nutzer hinzufügen" />
    </div>


	<li class="top_template" style="display:none;">
<!--		<div class="name" style="position:relative; float:none; left:200px; top:50px; width:60px; height:60px; background-color:#0066FF; vertical-align:middle; text-align:center;"><font style="vertical-align:middle">WM</font></div>
		<div class="removebox"><a class="remove" onsubmit="return false;" style="text-decoration:none">X</a></div>
-->					

		<div class="name" id="name">Name</div>
		
		
		<div class="timerbox">
			<span class="hour">00</span>:<span class="minute">00</span>:<span class="second">00</span>
		</div>
		
		<div class="buttons" id="startstop">START/STOP</div>
		
		<div class="buttons" id="reset" style="">RESET</div>
		
	</li>



	<li class="li_template">
<!--		<div class="name" style="position:relative; float:none; left:200px; top:50px; width:60px; height:60px; background-color:#0066FF; vertical-align:middle; text-align:center;"><font style="vertical-align:middle">WM</font></div>
-->					
		<div class="removebox"><a class="remove" onsubmit="return false;" style="text-decoration:none">X</a></div>
		<br /><div class="name" id="name">Name</div>
		
		
		<div class="timerbox">
			<span class="hour">00</span>:<span class="minute">00</span>:<span class="second">00</span>		</div>
		
		<div class="buttons" id="startstop" style="">START/STOP</div>
		<div class="buttons" id="wortmeldung">WM</div>
	</li>


<ul id="sortable">
	</ul>  
</body>

</html>

