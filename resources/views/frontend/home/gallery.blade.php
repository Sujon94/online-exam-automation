<section class="gallery section-padding" id="gallery">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title">
                    <h2>{{$gtext->content_title}}</h2>
                    <p>{!! html_entity_decode($gtext->content) !!}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portfolio-button text-center">
                    <button class="button is-checked" data-filter="*">all</button>
                    <button class="button" data-filter=".exam">exam</button>
                    <button class="button" data-filter=".contest">contest</button>
                    <!--<button class="button" data-filter=".tour">tour</button>-->
                    <button class="button" data-filter=".online-class">Online Class</button>
                </div>
            </div>
        </div>
        <div class="row grid-area">
            @foreach($gimg as $value)
                <div class="col-lg-4 col-md-6 col-sm-12 single-item {{$value->content_title}}">
                    <div class="gallery-img">
                        <img src="{{ asset('frontend/assets/image/' . $value->doc_file) }}" class="img-fluid" alt="">
                        <div class="gallery-single-overlay">
                            <a href="{{ asset('frontend/assets/image/' . $value->doc_file) }}" class="gallery-single"><i
                                        class="fa fa-search-plus"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
