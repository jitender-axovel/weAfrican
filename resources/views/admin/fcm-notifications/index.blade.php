<<<<<<< HEAD
@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
    <h2>Notification</h2>
    <hr>
    <div class="col-md-7 fcm-section">
        <section class="fcm_users" required>
            <header class="panel-heading"><strong>Select Users to whom you want to send Notification</strong> </header>
            <select class="form-control" id="select_type" name="select_action" required="">
                    <option value="" > Select </option>
                    <option value="1">Business users</option>
                    <option value="2">End Users</option>
                    <option value="3">All Users</option>
            </select>
        </section>
    </div>
    <div class="col-md-5 message-section">
        <p class="header">Type your message</p>
        <textarea cols="15" rows="5" value="txtarea"></textarea>
        <button onclick="sendMsg()">Send Message</button>
    </div>
    <div class="col-md-12 serverresponse hidediv">
        <center><button id="sendmsg">Send Message Again</button></center>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#users_list').DataTable();
        } );
    </script>
@endsection
@section('scripts')
<script>

	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	
    function sendMsg(){
   
        var msgLength = $.trim($("textarea").val()).length;
        
        if(msgLength == 0){
        	alert("You left the message field blank, please fill it");
        }else{

            var cus = document.getElementById('select_type');
            var custid = cus.options[cus.selectedIndex].value;

        	var formData = $(".wrapper").find("input").serialize() + "&message=" + $("textarea").val() + "&type=" +custid;	
        	$.ajax({type: "POST",data: formData, url: "{{url('admin/send/notification')}}", success:function(res){
        		$(".greetblock").slideUp(1000);
        		$(".serverresponse").prepend(res).hide().fadeIn(2000);
        	}});
        }
    }
    $(function(){
    	$(".serverresponse").hide()
    	$("input[type='checkbox']").click(function(){
    		if($(this).is(':checked')){
    			$(this).parent().css("border","3px solid red");
    		}else{
    			$(this).parent().css("border","0px");
    		}
    	});
    	
    	$("div.leftdiv, div.rightdiv").hover(function(){
    		$(this).css("background","#FAFAFA");
    	},function(){
    		$(this).css("background","#fff");
    	});
    	
    	$("#festival").change(function(){
    		$("img").attr("src",$(this).val());
    	});
    	
    	$("#sendmsg").click(function(){
    		$(".serverresponse").fadeOut(300,function(){
    			$(".greetblock").fadeIn(1000);
    		});		
    	});
    });
</script>
=======
@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
    <h2>Notification</h2>
    <hr>
    <div class="col-md-7 fcm-section">
        <section class="fcm_users" required>
            <header class="panel-heading"><strong>Select Users to whom you want to send Notification</strong> </header>
            <select class="form-control" id="select_type" name="select_action" required="">
                    <option value="" > Select </option>
                    <option value="1">Business users</option>
                    <option value="2">End Users</option>
                    <option value="3">All Users</option>
            </select>
        </section>
    </div>
    <div class="col-md-5 message-section">
        <p class="header">Type your message</p>
        <textarea cols="15" rows="5" value="txtarea"></textarea>
        <button onclick="sendMsg()">Send Message</button>
    </div>
    <div class="col-md-12 serverresponse hidediv">
        <center><button id="sendmsg">Send Message Again</button></center>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#users_list').DataTable();
        } );
    </script>
@endsection
@section('scripts')
<script>

	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	
    function sendMsg(){
   
        var msgLength = $.trim($("textarea").val()).length;
        
        if(msgLength == 0){
        	alert("You left the message field blank, please fill it");
        }else{
             var cus = document.getElementById('select_type');
            var custid = cus.options[cus.selectedIndex].value;
        	var formData = $(".wrapper").find("input").serialize() + "&message=" + $("textarea").val() + "&type=" +custid;	
        	$.ajax({type: "POST",data: formData, url: "{{url('admin/send/notification')}}", success:function(res){
        		$(".greetblock").slideUp(1000);
        		$(".serverresponse").prepend(res).hide().fadeIn(2000);
        	}});
        }
    }
    $(function(){
    	$(".serverresponse").hide()
    	$("input[type='checkbox']").click(function(){
    		if($(this).is(':checked')){
    			$(this).parent().css("border","3px solid red");
    		}else{
    			$(this).parent().css("border","0px");
    		}
    	});
    	
    	$("div.leftdiv, div.rightdiv").hover(function(){
    		$(this).css("background","#FAFAFA");
    	},function(){
    		$(this).css("background","#fff");
    	});
    	
    	$("#festival").change(function(){
    		$("img").attr("src",$(this).val());
    	});
    	
    	$("#sendmsg").click(function(){
    		$(".serverresponse").fadeOut(300,function(){
    			$(".greetblock").fadeIn(1000);
    		});		
    	});
    });
</script>
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2
@endsection