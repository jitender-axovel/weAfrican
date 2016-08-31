@extends('layouts.app')
@section('content')
<div class="first-section">
    <div class="container">
        <div class="download-weafrican">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <h2>weafrican</h2>
                <p>
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text 
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text
                </p>
                <ul class="list-inline">
                    <li><a href="#" class="download-link btn btn-default">download</a></li>
                    <li><a href="#" class="btn btn-default">Learn more</a></li>
                </ul>
                <div class="bottom-links">  
                    <ul class="list-inline">
                        <li><a href="#"><img src="{{asset('images/iphone-icon.png')}}"></a></li>
                        <li><a href="#"><img src="{{asset('images/download-icon.png')}}"></a></li>
                        <li><a href="#"><img src="{{asset('images/android-icon.png')}}"></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="app-image">
                    <img src="{{asset('images/mobile-app.png')}}">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="about-weafrican">
    <div class="container">
        <div class="text-center weafrican-detail">
            <h3>About <span class="blue-heading">weafrican</span></h3>
            <img src="{{asset('images/logo-icon.png')}}">
            <p>
                lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text 
                lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text
            </p>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-12">
                <img src="{{asset('images/demo-app.png')}}">
            </div>
            <div class="col-md-7 text-left app-intro col-sm-7 col-xs-12">
                <h4>Header <span class="blue-heading">one</span></h4>
                <p>
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text 
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text 
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text
                </p>
                <p>
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text 
                    lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text
                </p>    
                <ul class="download-links list-inline">
                    <li><a href="#" class="btn download-link btn-default">download</a></li>
                    <li><a href="#"class="btn btn-default site-button">learn more</a></li>
                </ul>
            </div>
        </div>
    </div>      
</div>
<div class="greyed-section">
    <div class="row">
        <div class="container">
            <div class="col-md-4 text-center col-sm-4 col-xs-12">
                <img src="{{asset('images/setting-icon.png')}}">
                <h4>header four</h4>
                <p>lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text</p>
            </div>
            <div class="col-md-4 text-center col-sm-4 col-xs-12">
                <img src="{{asset('images/blank-icon.png')}}">
                <h4>header four</h4>
                <p>lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text</p>
            </div>
            <div class="col-md-4 text-center col-sm-4 col-xs-12">
                <img src="{{asset('images/blank-icon.png')}}">
                <h4>header four</h4>
                <p>lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text</p>
            </div>
        </div>
    </div>
</div>  
<div class="app-features">
    <div class="row">
        <div class="container visible">
            <div class="text-center margin-bottom">
                <h3>Header <span class="blue-heading">one</span></h3>
                <img src="{{asset('images/logo-icon.png')}}">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod et dolore magna aliqua.
                </p>                        
            </div>                      
            <div class="col-md-7 feature-container col-sm-6 col-xs-12">
                    <img src="{{asset('images/app-features1.png')}}">
            </div>
            <div class="col-md-5 col-sm-6 col-xs-12">   
                <div class="feature-item">
                    <div class="left-side col-md-3">
                        <img src="{{asset('images/blank-icon.png')}}">
                    </div>
                    <div class="right-side col-md-9">
                        <h4>header four</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod et dolore magna aliqua.
                        </p>    
                    </div>
                </div>
                <div class="feature-item">
                    <div class="left-side col-md-3">
                        <img src="{{asset('images/blank-icon.png')}}">
                    </div>
                    <div class="right-side col-md-9">
                        <h4>header four</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod et dolore magna aliqua.
                        </p>    
                    </div>
                </div>
                <div class="feature-item">
                    <div class="left-side col-md-12">
                        <img src="{{asset('images/blank-icon.png')}}">
                    </div>
                    <div class="right-side col-md-12">
                        <h4>header four</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod et dolore magna aliqua.
                        </p>    
                    </div>
                </div>
                <div class="feature-item">
                    <div class="left-side col-md-3">
                        <img src="{{asset('images/blank-icon.png')}}">
                    </div>
                    <div class="right-side col-md-9">
                        <h4>header four</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod et dolore magna aliqua.
                        </p>    
                    </div>
                </div>
                <div class="feature-item">
                    <div class="left-side col-md-3">
                        <img src="{{asset('images/blank-icon.png')}}">
                    </div>
                    <div class="right-side col-md-9">
                        <h4>header four</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua.
                        </p>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="download-section text-center">
    <div class="row">
        <div class="container">
            <h3 class="white">download our <span class="blue-heading">latest app</span></h3>
            <img src="{{asset('images/white-logo.png')}}">
            <p class="white">lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text</p>
            <ul class="list-inline">
                <li> <a href="#"><img src="{{asset('images/download-apple.png')}}"></a> </li>
                <li> <a href="#"><img src="{{asset('images/download-playstore.png')}}"></a> </li>
                <li> <a href="#"><img src="{{asset('images/download-window.png')}}"></a> </li>
            </ul>
        </div>
    </div>
</div>
<div class="video-section text-center">
    <div class="row">
        <div class="container">
            <h3> app <span class="blue-heading"> video </span></h3>
            <img src="{{asset('images/logo-icon.png')}}">
            <p>
                lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text
                lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text lorem ipsum dummy text
            </p>
        </div>
    </div>
</div>