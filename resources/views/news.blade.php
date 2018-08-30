@extends('layouts.app')
@section('content')
<section id="page-content" class="page-wrapper" style="padding:50px 0px">
            <div class="about-sheltek-area ptb-115" style="padding-bottom: 0px !important;">
                <div class="container">
                    <div class="row">
                        <div class="section-title mb-30">
                            <h2>Twitter Feeds</h2>
                        </div>
                        <div class="about-sheltek-info">
                          <div class="row">
                              <a class="twitter-timeline"
                                 href="https://twitter.com/catocoin"
                                 data-tweet-limit="3">
                                  Tweets by @TwitterDev
                              </a>
                              <script async src="http://platform.twitter.com/widgets.js" charset="utf-8"></script>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
@endsection
