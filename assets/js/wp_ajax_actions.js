jQuery(document).ready(function($) {
	
		jQuery('#gc_generate_code').submit(function(event){
				event.preventDefault();
				jQuery("#search_firstname").val("");
				jQuery("#search_lastname").val('');
				
				jQuery("#gc_studentList").empty();
				var data = {
				'action': 'load_students',
				'school': $(this).find('select[name=school]').val(),      
				'year': $(this).find('select[name=year]').val()
			};
			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			draw_table(ajax_object.ajax_url, data);
			

		});
			



		});

		function filter_name(){
			// console.log(jQuery("#search_firstname").val());
			jQuery("#gc_studentList").empty();
			var data = {
				'action': 'load_students',
				'school': jQuery("#gc_generate_code").find('select[name=school]').val(),      
				'year': jQuery("#gc_generate_code").find('select[name=year]').val(),
				'firstName' : jQuery("#search_firstname").val(),
				'lastName' : jQuery("#search_lastname").val()
			};

			draw_table(ajax_object.ajax_url, data);

	}


	function draw_table(ajax_url, data){
		jQuery.post(ajax_url, data, function(response) {
				var object = JSON.parse(response);
				var container = jQuery("#gc_studentList");
				container.empty();
				let size=object.length;
				
				if(!size){
					var div = jQuery(document.createElement('div'));
					div.addClass("not-found");
					div.append(jQuery("<h2></h2>").html("Student not found"));
					container.append(div);
				}else{
					var header = jQuery(document.createElement('ul'));
					header.addClass("listinline");
					header.append(jQuery("<li></li>").html("<h3>Code</h3>"));
					header.append(jQuery("<li></li>").html("<h3>Class</h3>"));
					header.append(jQuery("<li></li>").html("<h3>Name</h3>"));
					header.append(jQuery("<li></li>").html("<h3>Portrait Qr</h3>"));
					header.append(jQuery("<li></li>").html("<h3>Family Qr</h3>"));
					container.append(header);
					for (let i=0; i<size; i++){
						let student = object[i];
						let next = (i<size)? i+1 :false;
						let prev = (i>0)?  i-1 :false;
						var row = jQuery(document.createElement('ul'));
						row.addClass("listinline item");
						var code = jQuery("<li></li>").html(student.user_login);
						var studentClass = jQuery("<li></li>").html(student.user_class);
						var name = jQuery("<li></li>").html(student.first_name+" "+student.last_name);	
						var email = jQuery("<li></li>").html(student.user_email);
						var whole_name=student.first_name+" "+student.last_name;

						var qrLink = jQuery("<a id='qr"+i+"' href='#'>portrait</a>").
																data("taget",'#myModal').
																data("name",whole_name+" (Portrait Shoot) "+student.user_login).
																data("id",student.user_login).
																data("next",next).
																data("prev",prev).
																addClass('myBtn portrait qrcode');

						var portrait = jQuery("<li></li>").append(qrLink);
						
						var family = jQuery("<li></li>").append("<a data-taget='#myModal' class='myBtn family qrcode' data-name='"+whole_name+" (Family Shoot) "+student.user_login+"' data-id='"+student.user_login+"-F' href='#'>family</a>");
						row.append(code,studentClass,name,portrait,family);
						container.append(row);
						
					}
				
					jQuery(".qrcode").on("click",function(event){
						event.preventDefault();
						var myModal = jQuery("#myModal"); 
						var code = jQuery(this).data('id');
						var args= {
										'cht': 'qr',
										'chs': '650x650',
										'chl' : code,
										'choe': 'UTF-8'
						};

						// var qrUrl= "https://chart.googleapis.com/chart?";
						var qrUrl= "https://api.qrserver.com/v1/create-qr-code/?";
						qrUrl += "data="+code+"&size="+args.chs;
						
						myModal.find('.sides').data("next",jQuery(this).data("next"));
						myModal.find('.sides').data("prev",jQuery(this).data("prev"));
						
						myModal.find('img').attr('src',qrUrl).on('load', function() {
				        jQuery("#myModal svg").show();
				        jQuery("#myModal img").hide();
				        jQuery("#myModal title").hide();alert(qrUrl);
				        if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
				            alert('broken image!');
				        } else {
				            jQuery("#myModal svg").hide();
				            jQuery("#myModal img").show();
				        }
				    });
						myModal.find('.modal-title').html(jQuery(this).data("name"));
					  myModal.addClass("show");
					   
					});
				}			
			});
	}
	
	/*// Get the modal
					var modal = jQuery('#myModal');

					// Get the button that opens the modal
					var btn = jQuery(".myBtn");

					// Get the <span> element that closes the modal
					var span = jQuery('#myModal .close');

					// When the user clicks the button, open the modal 
					btn.onclick = function() {
					    modal.css("display","block");
					}

					// When the user clicks on <span> (x), close the modal
					span.onclick = function() {
					    modal.css("display","none");
					}

					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
					    if (event.target == modal) {
					        modal.css("display","none");
					    }
					}
*/

	

	function selectPic(userID, filename,gallery){
		var data = {
				'action': 'my_action',
				'userID': userID,      
				'filename': filename,
				'gallery' : gallery
			};
			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post(ajax_object.ajax_url, data, function(response) {
				console.log("image selected: "+response);
			});
	}


	