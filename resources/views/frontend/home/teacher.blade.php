<section class="teachers section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title text-center">
                    <h2>{{$ot->content_title}}</h2>
                    {!! html_entity_decode($ot->content) !!}
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($tg as $value)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="teachers-area text-center">
                        <div class="teachers-member">
                            <img src="{{ asset('frontend/assets/image/' . $value->doc_file) }}" class="img-fluid" alt="">
                            <div class="teachers-overlay">
                                <div class="teachers-details">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="member-info" style="height: 110px;">
                            <h4>{{$value->content_title}}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>