<div class="wrap">
    <h2>Generate Qr Code</h2>
<div class="plugin-container">
  <form id="gc_generate_code" method="post" action="" >
    <?php 
      $terms = get_terms( array(
                      'taxonomy' => 'school',
                      'hide_empty' => false,
                        ) );
     ?>
    <fieldset>
      <legend>SELECT A SCHOOL</legend>
      <div class="wrapper">
        <div class="block"> 
          <div class="field">
           <label class="label">School:</label> 
            <select name="school" id="search_school" class="">
              <?php foreach ($terms as $key => $value) { ?>
                <option value="<?php echo $value->slug;?>" ><?php echo $value->name;?></option>
              <?php } ?>
            </select>
            <label class="label">Year</label> 
            <select name="year" class="">
                    <option value="16" >2016</option>
                    <option value="17" >2017</option>
            </select>
          </div>
            <?php submit_button('Search','primary'); ?>
        </div>        
      </div>
    </fieldset>
  </form>
  <div class="filters">
    <fieldset>
      <legend>Filter</legend>
        <div class="label">Name</div>
        <input id="search_firstname" type="text" onkeyup='filter_name()'>
        <div class="label">Surname</div>
        <input id="search_lastname" type="text" onkeyup='filter_name()'>
    </fieldset>
  </div>

  <svg width="200px"  height="200px"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-ripple">
    <circle cx="50" cy="50" r="25.2162" fill="none" ng-attr-stroke="{{config.c1}}" ng-attr-stroke-width="{{config.width}}" stroke="#4658ac" stroke-width="2">
      <animate attributeName="r" calcMode="spline" values="0;40" keyTimes="0;1" dur="1" keySplines="0 0.2 0.8 1" begin="-0.5s" repeatCount="indefinite"></animate>
      <animate attributeName="opacity" calcMode="spline" values="1;0" keyTimes="0;1" dur="1" keySplines="0.2 0 0.8 1" begin="-0.5s" repeatCount="indefinite"></animate>
    </circle>
    <circle cx="50" cy="50" r="39.9128" fill="none" ng-attr-stroke="{{config.c2}}" ng-attr-stroke-width="{{config.width}}" stroke="#e7008a" stroke-width="2">
      <animate attributeName="r" calcMode="spline" values="0;40" keyTimes="0;1" dur="1" keySplines="0 0.2 0.8 1" begin="0s" repeatCount="indefinite"></animate>
      <animate attributeName="opacity" calcMode="spline" values="1;0" keyTimes="0;1" dur="1" keySplines="0.2 0 0.8 1" begin="0s" repeatCount="indefinite"></animate>
    </circle>
  </svg>
  <div class="student_list" id="gc_studentList"></div>
  <!-- Modal -->
  <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title"></h4>
              
              </div>
              <div class="modal-body"><img src="" alt=""></div>
              
          </div>
          /.modal-content
      </div>
      /.modal-dialog
  </div> -->
  </div>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
     <div class="modal-header">
        <span class="close">&times;</span>
        <h4 class="modal-title"></h4>
       <!--  <a class="qrfamily" href="">show family</a>
       <a class="qrportrait" href="">show portrait</a> -->
     </div>
      <div class="modal-body">
        <img src="" alt="">
        
        <svg width="200px"  height="200px"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-ripple">
          <circle cx="50" cy="50" r="25.2162" fill="none" ng-attr-stroke="{{config.c1}}" ng-attr-stroke-width="{{config.width}}" stroke="#4658ac" stroke-width="2">
            <animate attributeName="r" calcMode="spline" values="0;40" keyTimes="0;1" dur="1" keySplines="0 0.2 0.8 1" begin="-0.5s" repeatCount="indefinite"></animate>
            <animate attributeName="opacity" calcMode="spline" values="1;0" keyTimes="0;1" dur="1" keySplines="0.2 0 0.8 1" begin="-0.5s" repeatCount="indefinite"></animate>
          </circle>
          <circle cx="50" cy="50" r="39.9128" fill="none" ng-attr-stroke="{{config.c2}}" ng-attr-stroke-width="{{config.width}}" stroke="#e7008a" stroke-width="2">
            <animate attributeName="r" calcMode="spline" values="0;40" keyTimes="0;1" dur="1" keySplines="0 0.2 0.8 1" begin="0s" repeatCount="indefinite"></animate>
            <animate attributeName="opacity" calcMode="spline" values="1;0" keyTimes="0;1" dur="1" keySplines="0.2 0 0.8 1" begin="0s" repeatCount="indefinite"></animate>
          </circle>
        </svg>


        <div class="sides">
          <a class="prev" href="">prev</a>
          <a class="next" href="">next</a>
        </div>
      </div>
  </div>

</div>
<script>

  

jQuery(document).ready(function(){
  // Get the modal
  jQuery("#myModal .close").on("click",function(){
    jQuery("#myModal").removeClass("show");
  });
  
 jQuery(".sides .next").on("click",function(e){
    e.preventDefault();
   /* jQuery("#myModal img").hide();
    jQuery("#myModal title").hide();
    jQuery("#myModal svg").show();*/
    // alert("changin next");
    var index = jQuery(this).parent(".sides").data("next");
    if (index!==false){
    // console.log(jQuery("#qr"+index));
    jQuery("#qr"+index).trigger("click");
    }else{
      alert("There is no more next students for this filtered");
    }

   
  });
 jQuery(".sides .prev").on("click",function(e){
    e.preventDefault();
    var index = jQuery(this).parent(".sides").data("prev");
    if (index!==false){
      jQuery("#qr"+index).trigger("click");
      // console.log(jQuery("#qr"+index));
    }else{
      alert("There is no more previous students for this filtered");
    }
    
   
  });
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === jQuery("#myModal")) {
       jQuery("#myModal").removeClass("show");
    }
}
});

</script>