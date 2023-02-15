<div class="banner-area black-bg-5 pt-65">
    <div class="container">
        <div class="row" style="padding: 50px">

            <div class="col-lg-6 col-md-6">
                <h2 style="color: white;">
                    {!! $about->{'title_en'} !!}
                </h2>
                <div class="aboutcontent">
                    {!! $about->details_en !!}
                </div>
            </div>

            <div class="col-lg-6 col-md-6" style="text-align: center">
                <img src="{{asset('/uploads/singlepages/'.$about->image)}}">
            </div>

        </div>
    </div>
</div>

