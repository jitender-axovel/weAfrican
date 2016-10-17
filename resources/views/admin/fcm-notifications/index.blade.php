@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
<h2>Notification</h2>
<div class="greetblock">
    <div class="leftdiv">
        <p class="header">Select Users to whom you want to send Notification
        </p>
        <table>
            <tr id="header">
                <td>Id</td>
                <td>User Name</td>
                <td>User Role</td>
                <td>Send Message?</td>
            </tr>
            @if($fcmUsers)
            @foreach($fcmUsers as $fcmUser)
            <tr>
                <td><span>{{$fcmUser->id}}</span></td>
                <td><span>{{$fcmUser->full_name}}</span></td>
                <td><span>@if($fcmUser->user_role_id == 3) BusinessUser @else EndUsers @endif</span></td>
                <td><span class="wrapper"><input type="checkbox" name="sendmsg[]" value="{{ $fcmUser->fcm_reg_id}}"/></span></td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- <div class="rightdiv">
        <p class="header">Select Greeting Card
        </p>
        <select id="festival">
            <option value="http://dev.mycareline.in/app/gcmwebapp/img/diwali.png">Diwali</option>
            <option value="http://dev.mycareline.in/app/gcmwebapp/img/pongal.png">Pongal</option>
            <option value="http://dev.mycareline.in/app/gcmwebapp/img/christmas.png">Christmas</option>
            <option value="http://dev.mycareline.in/app/gcmwebapp/img/ramzan.png">Ramadan</option>
        </select>
        <br/>
        <img src="http://dev.mycareline.in/app/gcmwebapp/img/diwali.png"/>
    </div> -->
    <div class="rightdiv">
        <p class="header">Type your message
        </p>
        <textarea cols="15" rows="5" value="txtarea"></textarea></br>
		<button onclick="sendMsg()">Send Message</button>
    </div>
    <div class="rightdiv">
        <!-- <p class="header">Send your customized message to your Users
        </p>
        <center>
            <button onclick="sendMsg()">Send Message</button>
        </center> -->
    </div>
</div>
<div class="serverresponse hidediv">
    <center><button id="sendmsg">Send Message Again</button></center>
</div>
@else
<div id="norecord">
    No records in MySQL DB
</div>
@endif
<style>
    table{width:100%;}
    tr > td {
    padding: 0.25rem;
    text-align: center;
    border: 1px solid #ccc;
    }
    tr:nth-child(even) {
    background: #fff;
    }
    tr:nth-child(odd) {
    background: #5bc0de;
    color: #fff;
    }
    tr#header{
    background: #5bc0de;
    }
    div#norecord{
    margin-top:10px;
    width: 15%;
    margin-left: auto;
    margin-right: auto;
    }
    input,select{
    cursor: pointer;
    }
    img{
    margin-top: 10px;
    height: 200px;
    width: 300px;
    }
    select{
    width: 200px
    }
    div.leftdiv{
    width: 45%;
    padding: 0 10px;
    float: left;
    border: 1px solid #ccc;
    margin: 5px;
    height: 320px;
    text-align:center;
    }
    div.rightdiv{
    width: 45%;
    padding: 0 10px;
    float: right;
    border: 1px solid #ccc;
    margin: 5px;
    height: 320px;
    text-align:center;
    }
    hidediv{
    display: none;
    }
    p.header{
    height: 40px;
    background-color: #5bc0de;
    padding: 10px;
    color: #fff;
    text-align:center;
    margin: 0;
    margin-bottom: 10px;
    }
    textarea{
    font-size: 25px;
    font-weight: bold;
    }
</style>
@endsection
@section('scripts')
<script>

	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	
    function sendMsg(){
    var msgLength = $.trim($("textarea").val()).length;
    var checkedCB = $("input[type='checkbox']:checked").length;
    if( checkedCB == 0){
    	alert("You must select atleast one User to send message");
    }else if(msgLength == 0){
    	alert("You left the message field blank, please fill it");
    }else{
    	var formData = $(".wrapper").find("input").serialize() + "&message=" + $("textarea").val();	
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
@endsection

