@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
@endsection
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">Edit Business Portfolio</h5>
        <hr>
        @include('notification')
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="panel panel-default document">
            <form id="register-form" class="form-horizontal" action="{{ url('portfolio/'.$businessPorfolio->id) }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="row">
                    <label for="maritial_status" class="col-md-2 control-label required">Maritial Status:</label>
                    <div class="col-md-4 form-group">
                        <select name="maritial_status" id="maritial_status" class="form-control selectpicker">
                           <option value="">Select One</option>
                           <option @if($businessPorfolio->maritial_status=="married") selected="selected" @endif value="married">Married</option>
                           <option @if($businessPorfolio->maritial_status=="single") selected="selected" @endif value="single">Single</option>
                           <option @if($businessPorfolio->maritial_status=="divorced") selected="selected" @endif value="divorced">Divorced</option>
                        </select>
                        @if ($errors->has('maritial_status'))
                            <span class="help-block">
                            <strong>{{ $errors->first('maritial_status') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="occupation" class="col-md-2 control-label required">Occupation:</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" value="{{$businessPorfolio->occupation}}" name="occupation" id="occupation">
                        @if ($errors->has('occupation'))
                            <span class="help-block">
                            <strong>{{ $errors->first('occupation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="acadmic" class="col-md-2 control-label">Academic Status:</label>
                    <div class="col-md-4 form-group">
                        <select name="acedimic_status" id="acedimic_status" class="form-control selectpicker">
                           <option value="">Select One</option>
                           <option @if($businessPorfolio->acedimic_status=="10") selected="selected" @endif value="10">10</option>
                           <option @if($businessPorfolio->acedimic_status=="10+2") selected="selected" @endif value="10+2">10+2</option>
                           <option @if($businessPorfolio->acedimic_status=="Graduate") selected="selected" @endif value="Graduate">Graduate</option>
                           <option @if($businessPorfolio->acedimic_status=="Post Graduate") selected="selected" @endif value="Post Graduate">Post Graduate</option>
                           <option @if($businessPorfolio->acedimic_status=="Diploma") selected="selected" @endif value="Diploma">Diploma</option>
                        </select>
                        @if ($errors->has('acedimic_status'))
                            <span class="help-block">
                            <strong>{{ $errors->first('acedimic_status') }}</strong>
                            </span>
                        @endif
                    </div>
                
                    <label for="key_skills" class="col-md-2 control-label required">Key Skills:</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" name="key_skills" value="{{$businessPorfolio->key_skills}}" id="key_skills">
                        @if ($errors->has('key_skills'))
                            <span class="help-block">
                            <strong>{{ $errors->first('key_skills') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @if($category_check==1)
                    <div class="row">
                        <label for="category" class="col-md-2 required control-label">Experience</label>
                        <div class="col-md-2 form-group">
                            <select class="form-control" id="experience_years" name="experience_years">
                                <option value="">Select Years</option>
                                @for($i=1;$i<=30;$i++)
                                    <option @if($businessPorfolio->experience_years==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('experience_years'))
                                <span class="help-block">
                                <strong>{{ $errors->first('experience_years') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 form-group">
                            <select class="form-control" id="experience_months" name="experience_months">
                                <option value="">Select Months</option>
                                @for($i=1;$i<=12;$i++)
                                    <option @if($businessPorfolio->experience_months==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('experience_months'))
                                <span class="help-block">
                                <strong>{{ $errors->first('experience_months') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="name" class="col-md-2 required control-label">Height</label>
                        <div class="col-md-2 form-group">
                            <select class="form-control" name="height_feets">
                                <option value="">Feets</option>
                                @for($i=1;$i<=30;$i++)
                                    <option @if($businessPorfolio->height_feets==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('height_feets'))
                                <span class="help-block">
                                <strong>{{ $errors->first('height_feets') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 form-group">
                            <select class="form-control" name="height_inches">
                                <option value="">inches</option>
                                @for($i=1;$i<=12;$i++)
                                    <option @if($businessPorfolio->height_inches==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('height_inches'))
                                <span class="help-block">
                                <strong>{{ $errors->first('height_inches') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="category" class="col-md-2 required control-label">Hair type</label>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="hair_type">
                                <option value="">Select Hair type</option>
                                <option @if($businessPorfolio->hair_type=="Long") selected="selected" @endif value="Long">Long</option>
                                <option @if($businessPorfolio->hair_type=="Medium") selected="selected" @endif value="Medium">Medium</option>
                                <option @if($businessPorfolio->hair_type=="Short") selected="selected" @endif value="Short">Short</option>
                                <option @if($businessPorfolio->hair_type=="Curly") selected="selected" @endif value="Curly">Curly</option>
                                <option @if($businessPorfolio->hair_type=="Bald") selected="selected" @endif value="Bald">Bald</option>
                            </select>
                            @if ($errors->has('hair_type'))
                                <span class="help-block">
                                <strong>{{ $errors->first('hair_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="category" class="col-md-2 required control-label">Hair Colour</label>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="hair_color">
                                <option value="">Select Hair Color</option>
                                <option @if($businessPorfolio->hair_color=="Red") selected="selected" @endif value="Red">Red</option>
                                <option @if($businessPorfolio->hair_color=="Black/Brown") selected="selected" @endif value="Black/Brown">Black/Brown</option>
                                <option @if($businessPorfolio->hair_color=="Blonde") selected="selected" @endif value="Blonde">Blonde</option>
                                <option @if($businessPorfolio->hair_color=="Silver/Grey") selected="selected" @endif value="Silver/Grey">Silver/Grey</option>
                                <option @if($businessPorfolio->hair_color=="Coloured") selected="selected" @endif value="Coloured">Coloured</option>
                            </select>
                            @if ($errors->has('hair_color'))
                                <span class="help-block">
                                <strong>{{ $errors->first('hair_color') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="category" class="col-md-2 required control-label">Skin Colour</label>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="skin_color">
                                <option value="">Select Hair type</option>
                                <option @if($businessPorfolio->skin_color=="Light") selected="selected" @endif value="Light">Light</option>
                                <option @if($businessPorfolio->skin_color=="Dusky") selected="selected" @endif value="Dusky">Dusky</option>
                                <option @if($businessPorfolio->skin_color=="Wheatish") selected="selected" @endif value="Wheatish">Wheatish</option>
                                <option @if($businessPorfolio->skin_color=="Mix") selected="selected" @endif value="Mix">Mix</option>
                            </select>
                            @if ($errors->has('skin_color'))
                                <span class="help-block">
                                <strong>{{ $errors->first('skin_color') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkbox" class="col-md-2 control-label">Professional Training </label>
                        <div class="col-md-10 form-group">
                            <input name="professional_training" id="professional_training" value="1" type="checkbox" @if($businessPorfolio->professional_training==1) checked="checked" @endif > I have professional training from institute
                            @if ($errors->has('professional_training'))
                                <span class="help-block">
                                <strong>{{ $errors->first('professional_training') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row" id="institute" @if($businessPorfolio->professional_training!=1) style="display: none;" @endif >
                        <label for="checkbox" class="col-md-2 required control-label">Institute Name</label>
                        <div class="col-md-4 form-group">
                            <input type="text" id="institute_name" data-bv-notempty="false" class="form-control" required="required" name="institute_name" value ="{{ $businessPorfolio->institute_name }}">
                            @if ($errors->has('institute_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('institute_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
                <div>
                    <legend>Portfolio Image</legend>
                </div>
                <div class="row mb-1">
                    <label for="portfolio_image_1" class="col-md-2 required control-label">Image</label>
                    <div class="col-md-3 form-group">
                        <input name="portfolio_image_1" id="portfolio_image_1" value="{{ old('portfolio_image_1') }}" type="file" onchange="previewImg(this)" @if(!($businessPorfolio->image!=NULL and explode('|',$businessPorfolio->image)[0]!="")) required="required" @endif>
                        @if ($errors->has('portfolio_image_1'))
                            <span class="help-block">
                            <strong>{{ $errors->first('portfolio_image_1') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="logo_preview_1" class="col-md-1 control-label">
                        Preview:
                    </label>
                    <div class="col-md-2">
                        @if($businessPorfolio->image!=NULL and explode('|',$businessPorfolio->image)[0]!="")
                            <img src="{{asset(config('image.portfolio_image_url').'thumbnails/small/'.explode('|',$businessPorfolio->image)[0])}}" alt="" class="previewImg" id="preview_1">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt="" class="previewImg" id="preview_1">
                        @endif
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="featured_image" value="1" @if($businessPorfolio->featured_image==1 or $businessPorfolio->featured_image==0) checked="checked" @endif >&nbsp;&nbsp;&nbsp;<label for="checkbox" class="control-label">Set Featured Image</label>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="portfolio_image_2" class="col-md-2 control-label">Image</label>
                    <div class="col-md-3">
                        <input name="portfolio_image_2" id="portfolio_image_2" value="{{ old('portfolio_image_2') }}" onchange="previewImg(this)" type="file">
                        @if ($errors->has('portfolio_image_2'))
                            <span class="help-block">
                            <strong>{{ $errors->first('portfolio_image_2') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="logo_preview_2" class="col-md-1 control-label">
                        Preview:
                    </label>
                    <div class="col-md-2">
                        @if($businessPorfolio->image!=NULL and explode('|',$businessPorfolio->image)[1]!="")
                            <img src="{{asset(config('image.portfolio_image_url').'thumbnails/small/'.explode('|',$businessPorfolio->image)[1])}}" alt="" class="previewImg" id="preview_2">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt="" class="previewImg" id="preview_2">
                        @endif
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="featured_image" @if($businessPorfolio->featured_image==2) checked="checked" @endif value="2">&nbsp;&nbsp;&nbsp;<label for="checkbox" class="control-label">Set Featured Image</label>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="portfolio_image_3" class="col-md-2 control-label">Image</label>
                    <div class="col-md-3">
                        <input name="portfolio_image_3" id="portfolio_image_3" value="{{ old('portfolio_image_3') }}" onchange="previewImg(this)" type="file">
                        @if ($errors->has('portfolio_image_3'))
                            <span class="help-block">
                            <strong>{{ $errors->first('portfolio_image_3') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="logo_preview_3" class="col-md-1 control-label">
                        Preview:
                    </label>
                    <div class="col-md-2">
                        @if($businessPorfolio->image!=NULL and explode('|',$businessPorfolio->image)[2]!="")
                            <img src="{{asset(config('image.portfolio_image_url').'thumbnails/small/'.explode('|',$businessPorfolio->image)[2])}}" alt="" class="previewImg" id="preview_3">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt="" class="previewImg" id="preview_3">
                        @endif
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="featured_image" @if($businessPorfolio->featured_image==3) checked="checked" @endif value="3">&nbsp;&nbsp;&nbsp;<label for="checkbox" class="control-label">Set Featured Image</label>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="portfolio_image_4" class="col-md-2 control-label">Image</label>
                    <div class="col-md-3">
                        <input name="portfolio_image_4" id="portfolio_image_4" value="{{ old('portfolio_image_4') }}" onchange="previewImg(this)" type="file">
                        @if ($errors->has('portfolio_image_4'))
                            <span class="help-block">
                            <strong>{{ $errors->first('portfolio_image_4') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="logo_preview_4" class="col-md-1 control-label">
                        Preview:
                    </label>
                    <div class="col-md-2">
                        @if($businessPorfolio->image!=NULL and explode('|',$businessPorfolio->image)[3]!="")
                            <img src="{{asset(config('image.portfolio_image_url').'thumbnails/small/'.explode('|',$businessPorfolio->image)[3])}}" alt="" class="previewImg" id="preview_4">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" class="previewImg" alt=""  id="preview_4">
                        @endif
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="featured_image" @if($businessPorfolio->featured_image==4) checked="checked" @endif value="4">&nbsp;&nbsp;&nbsp;<label for="checkbox" class="control-label">Set Featured Image</label>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="portfolio_image_5" class="col-md-2 control-label">Image</label>
                    <div class="col-md-3">
                        <input name="portfolio_image_5" id="portfolio_image_5" value="{{ old('portfolio_image_5') }}" onchange="previewImg(this)" type="file">
                        @if ($errors->has('portfolio_image_5'))
                            <span class="help-block">
                            <strong>{{ $errors->first('portfolio_image_5') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="logo_preview_5" class="col-md-1 control-label">
                        Preview:
                    </label>
                    <div class="col-md-2">
                        @if($businessPorfolio->image!=NULL and explode('|',$businessPorfolio->image)[4]!="")
                            <img src="{{asset(config('image.portfolio_image_url').'thumbnails/small/'.explode('|',$businessPorfolio->image)[2])}}" class="previewImg" alt=""  id="preview_5">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" class="previewImg" alt=""  id="preview_5">
                        @endif
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="featured_image" @if($businessPorfolio->featured_image==5) checked="checked" @endif value="5">&nbsp;&nbsp;&nbsp;<label for="checkbox" class="control-label">Set Featured Image</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                        Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('header-scripts')
<style type="text/css">
    .mb-1 {margin-bottom: 20px;}
</style>
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyDEOk91hx04o7INiXclhMwqQi54n2Zo0gU&libraries=places'></script>
    <script src="{{ asset('js/dist/locationpicker.jquery.js') }}"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        //Bootstarp validation on form
        $(document).ready(function() {
            $('#register-form')

            .find('[name="maritial_status"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'maritial_status');
            })
            .end()

            .find('[name="academic"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'academic');
            })
            .end()

            .find('[name="experience_years"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'experience_years');
            })
            .end()

            .find('[name="experience_months"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'experience_months');
            })
            .end()

            .find('[name="height_feets"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'height_feets');
            })
            .end()

            .find('[name="height_inches"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'height_inches');
            })
            .end()

            .find('[name="hair_type"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'hair_type');
            })
            .end()

            .find('[name="hair_color"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'hair_color');
            })
            .end()

            .find('[name="skin_color"]')
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').bootstrapValidator('revalidateField', 'skin_color');
            })
            .end()

            .bootstrapValidator({
                // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    maritial_status: {
                        validators: {
                            notEmpty: {
                                message: 'Please select Maritial Status.'
                            }
                        }
                    },acedimic_status: {
                        validators: {
                            notEmpty: {
                                message: 'Please select Academic.'
                            }
                        }
                    },
                    experience_years: {
                        validators: {
                            notEmpty: {
                                message: 'Please select Exp. Year.'
                            }
                        }
                    },
                    experience_months: {
                        validators: {
                            notEmpty: {
                                message: 'Please select Exp. months.'
                            }
                        }
                    },
                    height_feets: {
                        validators: {
                            notEmpty: {
                                message: 'Please select Your Height in feets.'
                            }
                        }
                    },
                    height_inches: {
                        validators: {
                            notEmpty: {
                                message: 'Please select Your Height in inches.'
                            }
                        }
                    },
                    hair_type: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your hair type.'
                            }
                        }
                    },
                    hair_color: {
                        validators: {
                            notEmpty: {
                                message: 'Please select hair color'
                            }
                        }
                    },
                    skin_color: {
                        validators: {
                            notEmpty: {
                                message: 'Please select skin color.'
                            }
                        }
                    },
                    institute_name: {
                        validators: {
                            notEmpty: {
                                message: 'Please Enter your Institute Name'
                            }
                        }
                    },
                    occupation: {
                        validators: {
                            notEmpty: {
                                message: 'Please Enter your Occupation'
                            }
                        }
                    },
                    key_skills: {
                        validators: {
                            notEmpty: {
                                message: 'Please Enter your Key Skills'
                            }
                        }
                    },
                }
            })
            .on('success.form.bv', function(e) {
                $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                    $('#register-form').data('bootstrapValidator').resetForm();

                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function(result) {
                    console.log(result);
                }, 'json');
            });
        });
    </script>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript">

    function previewImg(img)
    {
        var id = img.id[img.id.length -1];
        input = "#preview"+img.id[img.id.length -1];
        if (img.files && img.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview_'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(img.files[0]);
        }
    }
    
    $("#banner").change(function(){
        readURL(this);
    });
    var bootstrapValidator = $('#register-form').data('bootstrapValidator');
    $('#professional_training').click(function() {
      $('#institute')[this.checked ? "show" : "hide"]();
      if(this.checked)
      {
        $("#register-form").bootstrapValidator('enableFieldValidators', institute_name, 'notEmpty', false)
      }else
      {
        $("#register-form").bootstrapValidator('enableFieldValidators', institute_name, 'notEmpty', true);
      }
       
    });
    

</script>
@endsection