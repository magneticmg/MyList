<?php

/*==========================================================================*\
 || ######################################################################## ||
 || # MMInc PHP                                                            # ||
 || # Project: MyList                                             # ||
 || #  $Id:  $                                                             # ||
 || # $Date:  $                                                            # ||
 || # $Author:  $                                                          # ||
 || # $Rev: $                                                              # ||
 || # -------------------------------------------------------------------- # ||
 || # @Copyright (C) 2010 - Cameron Barr, Magnetic Merchandising Inc.      # ||
 || # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html                # ||
 || # -------------------------------------------------------------------- # ||
 || # http://www.magneticmerchandising.com  info@magneticmerchandising.com # ||
 ||                                                                          ||
 || # -------------------------------------------------------------------- # ||
 || ######################################################################## ||
 \*==========================================================================*/
?>
       <div class="sort">
                     <button id="priority_sort" dir="DESC" rel="priority">Sort By Priority</button>                    
                     <button id="duedate_sort" dir="DESC" rel="duedate">Sort By Duedate</button>                    
                </div>
                <div style="clear: both;"></div>
<!--                <ul id="mylist"></ul>-->
<table id="mylist_table">
    <tbody id="mylist"></tbody>
</table>
<div><a href="#" id="add" rel="0">add</a>
<!--    <a href="#" id="delete" rel="0">delete</a></div>-->
                 <div id="message"></div>
                 <div id="form-container"></div>
                 <div id="loginform-container">
                     <div id="login-box" style="display:none">
                     <?php 
                     
                         echo $this->loadTemplate("login") ;?>
                    </div>
                 </div>
            </div>
<div id="usage">
    <h3>Usage</h3>
    <ul>
        <li>Each request must have ?p=demo&amp;a=demo attached to the request. a is the username and p is the password. Same for the REST part</li>
        
        <li>You can change the sort order by clicking the Buttons about the list. </li>
        <li>Click edit to load the form.</li>
        <li>Click delete to get rid of the item.</li>
    </ul>
    <h3>REST</h3>
    <ul><li>
            Use http://example.com/resource/item/[LIST ITEM ID]?p=demo&amp;a=demo to get JSON of the item, i.e. <b>http://example.com/resource/item/8?p=demo&amp;a=demo</b>
        </li>
        <li>
         Use http://example.com/resource/list/?p=demo&amp;a=demo to get JSON of the entire list.
        </li>
    </ul>
</div>
        
    </div>
    
<script type="text/javascript">


        
        $(document).ready(function(){
             
               var url = "index.php";
               var mylist = $("#mylist");
               var a = '<?php echo JRequest::getVar('a') ?>';
               var p = '<?php echo JRequest::getVar('p') ?>';
             /**
              *  Thank you: http://www.foliotek.com/devblog/make-table-rows-sortable-using-jquery-ui-sortable/ 
              */      
             var widthHelper = function(e, ui) {
                    ui.children().each(function() {
                            $(this).width($(this).width());
                    });
                    return ui;
             }; 

              var saveItem = function(e){
                      
                   e.preventDefault();
                   
                   var data = $("#form").serialize();
                  
                   var callback = function(data){
                       var message = $("#message");          
                       // Good? Empty and out put message
                       if(data.status){
                           
                           $('#form-container').empty();
                           
                                    message.append('<div class="good">'+data.message+'</div>')
                                    .delay(3000)
                                    .fadeOut(400);
                                               
                                     loadItems();
                       } else {
                           message.append('<div class="bad">'+data.message+'<br>'+data.error+'</div>')
                                  .delay(3000)
                                  .fadeOut(400);
                       }
                  }
                  $.post("index.php", data + "&p="+p+"&a="+a, callback, 'json')
               }
              var readyForm = function(){


                    $("#form").submit(saveItem);
                    $( "#jform_duedate" ).datepicker();
                    $("#submit").button();
                    
                    
                      
              }
              
               var loadItems = function(e){
               
         
                  // Callback
                    var callback = function(data){
                    mylist.empty();
               
                        // GET Items
                        $(data).each(function(el, datum){

                            mylist.append("<tr id='"+datum.mylist_item_id+"'><td><input style='display:none' name='item' value='"+datum.mylist_item_id+"' type='checkbox' /><a id='link_"+datum.mylist_item_id+"' rel="+datum.mylist_item_id+" class='edit' href='#'>edit</a><a id='link_delete_"+datum.mylist_item_id+"' rel="+datum.mylist_item_id+" class='delete' href='#'>delete</a></td><td>"+datum.item+"</td><td class='ui-line'>"+datum.status+" %</td><td class='ui-line'>"+datum.priority+"</td><td>"+datum.duedate+"</td></tr>");
                        });
                        // END: GET Items
                       
                       // add edit
                        $("a.edit, a#add").click(function(e){
                            e.preventDefault();
                            var id = $(this).attr('rel');
                            // load the form and attach event handler
                            $("#form-container").load('index.php?view=item&tmpl=json&id='+id+ "&p="+p+"&a="+a, readyForm);
                    
                        })
                        // END: add edit
                        $("a.delete").click(function(e){
                            e.preventDefault();
                            var id = $(this).attr('rel');
                            var data = {task: 'item.delete', id: id, a: a, p: p}
                   
                            var callback = function(data){

                                var message = $("#message");          
                                // Good? Empty and out put message
                                if(data.status){

                                                message.append('<div class="good">'+data.message+'</div>')
                                                .delay(3000)
                                                .fadeOut(400);
                                                loadItems();
                                } else {
                                    message.append('<div class="bad">'+data.message+'</div>')
                                            .delay(3000)
                                            .fadeOut(400);
                                }
                            }
                            $.post(url, data, callback, 'json');
                        });
                      // Attach sortable
                      
                      $( "tbody#mylist" ).sortable({
                                            helper:widthHelper,
                                            stop: function(event, ui){
                                                console.log($(this).sortable('toArray'));
                                            }
                               }).disableSelection();
                               //END: Attach sortable
             
                        
                    }// END : Callback
               var order = $.data(mylist, 'order');
               var dir = $.data(mylist, 'dir');
               //console.log($.data(mylist), 150);
               var dataType = 'json';
               var data = {view: "list", format:"json", order: order, dir: dir, p: p, a: a};
               
               $("button#duedate_sort, button#priority_sort").click(function(){
                         
                         $.data(mylist, 'order', $(this).attr('rel'));
                         
                         // get current direction of button
                         var bdir = $(this).attr('dir');
                         
                         $.data(mylist, 'dir', bdir);
                        
                         if(bdir == "DESC"){
                        
                            $(this).attr('dir', "ASC");
                         } else {
                            $(this).attr('dir', "DESC");
                         }
                         
                    }).click(loadItems);
               
                $.get(url, data, callback, dataType);
               
              };
               
                /**
                 * Attach consisten handlers/plugins
                 */
        	$(function() {
                    
                    $("#priority_sort, a#add").button();
                   
                    //$("a#delete").button({disabled: true});
                    
                    $("button#duedate_sort").click(function(){
                         
                    });
                    $("#duedate_sort, #login_button").button();
           	});
            /**
                *  Initialize the items 
                */
               $.data(mylist, 'order', "duedate");
               $.data(mylist, 'dir', "DESC");
               loadItems();
             
               
        });

</script> 