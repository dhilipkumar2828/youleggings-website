@extends('frontend.layouts.arrivals_products_master_new')
@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
        <style>
            section.browse-list-section.mobviewsecone {
                display: none;
            }

            @media only screen and (max-width: 767px) {
                col-6.col-lg-4.col-md-6.col-sm-6.mb-1.mb-sm-9.searchgridcol {
                    width: 50% !important;
                }

                section.browse-list-section.mobviewsecone {
                    display: block;
                }

                .topnavnewmega {

                    display: none;
                }
            }

            .size-buttons-tipAndBtnContainer {
                margin: 10px 6px 10px 0;
            }

            .size-buttons-unified-size {
                margin: 0;
                font-size: 11px;
                padding: 0;
                font-weight: 700;
            }

            .size-buttons-size-button-default {
                background-color: #fff;
                border: 1px solid #bfc0c6;
                border-radius: 50px;
                padding: 0;
                min-width: 35px;
                height: 35px;
                text-align: center;
                cursor: pointer;
                color: #282c3f;
                -webkit-box-flex: 0;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                position: relative;
            }

            #testimonials {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                width: 100%;
            }

            section.top-product-list-section.mt-5.mb-5 {
                padding-bottom: 40px;
            }

            #owl-two.owl-carousel .owl-nav {
                display: block !important;
            }

            .testimonial-heading {
                letter-spacing: 1px;
                margin: 30px 0px;
                padding: 10px 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .testimonial-heading span {
                font-size: 1.3rem;
                color: #252525;
                margin-bottom: 10px;
                letter-spacing: 2px;
                text-transform: uppercase;
            }

            .testimonial-box-container {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                width: 100%;
                padding-bottom: 50px;
            }

            .testimonial-box {
                width: 515px;
                box-shadow: 2px 2px 30px rgba(0, 0, 0, 0.1);
                background-color: #ffffff;
                padding: 20px;
                margin: 15px;
                cursor: pointer;
            }

            .profile-img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                overflow: hidden;
                margin-right: 10px;
            }

            .profile-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
                margin-top: -45px;
            }

            .profile {
                display: flex;
                align-items: center;
            }

            .name-user {
                display: flex;
                flex-direction: column;
            }

            .name-user strong {
                color: #3d3d3d;
                font-size: 1.1rem;
                letter-spacing: 0.5px;
            }

            .name-user span {
                color: #979797;
                font-size: 0.8rem;
            }

            .reviews {
                color: #f9d71c;
                font-size: 20px;
            }

            .box-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .client-comment p {
                font-size: 0.9rem;
                color: #4b4b4b;
            }

            .testimonial-box:hover {
                transform: translateY(-10px);
                transition: all ease 0.3s;
            }

            @media(max-width:1060px) {
                .testimonial-box {
                    width: 45%;
                    padding: 10px;
                }
            }

            @media(max-width:790px) {
                .testimonial-box {
                    width: 100%;
                }

                .testimonial-heading h1 {
                    font-size: 1.4rem;
                }
            }

            @media(max-width:340px) {
                .box-top {
                    flex-wrap: wrap;
                    margin-bottom: 10px;
                }

                .reviews {
                    margin-top: 10px;
                }
            }

            ul.size li {
                display: inline-flex;
                width: 10%;
                height: 26px;
                background: linear-gradient(180deg, #223f65, #0e1a30);
                padding: 4px 0 20px 3px;
                font-size: 10px;
                color: #fff;
                list-style-position: inside;
                /* text-align: center; */
                font-weight: 600;
                border: 1px solid #1111111c;
            }

            ul.size {
                padding-top: 10px;
            }

            .product-card {
                position: relative;
                box-sizing: border-box;
                border-radius: 12px;
                border: 1px solid #11111105;
                padding: 25px;
                box-shadow: 0px 0px 29px 0px #23194238;
            }

            button.add-to-cart.add_tocart_modal {
                display: inline-flex;
                justify-content: center;
                align-items: center;
                border: 0;
                cursor: pointer;
                padding: 5px 3rem;
                font: inherit;
                font-size: 16px;
                text-decoration: none;
                color: rgb(var(--color-button-text));
                transition: box-shadow var(--duration-short) ease;
                -webkit-appearance: none;
                appearance: none;
                background-color: #fff;
                border: 1px solid #b00;
                border-radius: 42px;
                margin-top: 20px;
            }

            .header-logo.ml-10 a {
                font-size: 21px !important;
                margin-top: 15px !important;
                margin-bottom: 15px !important;
            }

            .owl-carousel .owl-nav button.owl-next {
                position: absolute;
                right: 0px !important;
                top: 60px !important;
                font-size: 39px !important;
            }

            .owl-carousel .owl-nav button.owl-prev {
                position: absolute;
                left: -15px !important;
                top: 60px !important;
                font-size: 39px !important;
            }

            .owl-theme .owl-dots .owl-dot {
                display: inline-block;
                zoom: 1;
                margin-top: 40px;
            }

            section.browse-list-section {
                padding-bottom: 30px;
            }

            .owl-theme .owl-dots .owl-dot span {
                width: 10px;
                height: 10px;
                margin: 5px 7px;
                background: #bb0000;
                display: block;
                -webkit-backface-visibility: visible;
                transition: opacity .2s ease;
                border-radius: 30px
            }

            .parallax-section {
                height: 80vh;
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                display: flex;
                justify-content: center;
                align-items: center;
                color: white;
                text-align: center;
                font-size: 3em;

            }

            .parallax1 {
                background-image: url('frontend/img/banner-praaya.png');
            }

            @media (max-width: 767px) {
                owl-carousel .owl-nav button.owl-prev {
                    position: absolute;
                    left: 0 !important;
                    top: 60px !important;
                    font-size: 39px !important;
                }

                .header-logo.ml-10 a {
                    font-size: 18px !important;
                    margin-top: 15px !important;
                    margin-bottom: 15px !important;
                    line-height: 24px;
                }

                .search-btn {
                    position: absolute;
                    right: 0;
                    top: 2px;
                    padding: 0px 30px;
                    height: 20px;
                    display: inline-block;
                    border: none;
                    padding: 10px 30px;
                    -webkit-transition: 0.5s;
                    transition: 0.5s;
                    text-transform: uppercase;
                    background-color: #f2d6c300;
                    color: black;
                    font-size: 14px;
                    font-weight: 600;
                    left: 320px;
                    border-radius: 91px;
                }

            }

            .newsletter-content-wrap .subscribe_title {

                line-height: 61px;

                font-size: 45px;

                font-weight: 600;

                color: #0f0e0e;

            }

            .offer {
                display: flex;
                align-items: center;
                border: 1px dashed #000227;
                border-radius: 0;
                margin-bottom: 20px;
                padding: 10px;
                background-color: #f0fdf4;
                text-align: left;
                background: url(frontend/img/banner-praayasha.jpg) !important;
                background-size: cover !important;
                background-position: center !important;
            }

            .offer-text {
                background-color: #fff;
                color: #192e4c;
                border-radius: 5px;
                padding: 5px;
                margin-right: 10px;
                font-weight: bold;
                font-size: 14px;
                /* flex: 0 0 100px; */
                text-align: center;
            }

            .offer p {
                margin: 0;
                flex: 1;
                font-size: 20px;
                text-align: center;
                color: #fff;
            }

            .offer-code {
                cursor: pointer;
                background-color: #fff;
                padding: 5px;
                border-radius: 5px;
                display: inline-block;
                margin-left: 10px;
                font-weight: bold;
                color: #192e4c;
                font-size: 14px;
                /* flex: 0 0 100px; */
                text-align: center;
            }
        </style>
        <style>
            .size-buttons-select-size {
                display: inline-block;
                font-size: 16px;
                margin: 0;
                font-weight: 700
            }

            .inc.qty-btn {
                font-size: 20px !important;
            }

            .size-buttons-tipAndBtnContainer {
                margin: 10px 0px 10px 4px;
            }

            .size-buttons-size-header {
                margin: 0 0 10px;
                position: relative;
                line-height: 1
            }

            .size-buttons-size-chart {
                margin-left: 30px
            }

            .size-buttons-arrow {
                display: inline-block;
                width: 6px;
                height: 6px;
                margin-left: 4px;
                border: solid #ff3e6c;
                border-width: 2px 2px 0 0;
                -webkit-transform: rotate(45deg);
                transform: rotate(45deg);
                margin-bottom: 2px
            }

            .size-buttons-show-size-chart {
                outline: 0;
                background-color: transparent;
                border: 0;
                letter-spacing: .5px;
                text-align: right;
                padding: 0 0 5px;
                color: #ff3e6c;
                font-size: 14px;
                font-weight: 700;
                text-transform: uppercase;
                margin-top: 0
            }

            .size-buttons-arrowRightBold {
                position: relative;
                top: 4px;
                color: #ff3e6c;
                -webkit-transform: scale(.8);
                transform: scale(.8)
            }

            .size-buttons-sizeTip {
                position: absolute;
                top: 0;
                left: 0;
                height: 1px;
                min-width: 400px;
                visibility: hidden;
                -webkit-transition: visibility .1s ease-out;
                transition: visibility .1s ease-out;
                -webkit-transition-delay: .1s;
                transition-delay: .1s
            }

            .size-buttons-sizeTip .size-buttons-sizeTipMeta {
                position: absolute;
                min-width: 400px;
                left: 0;
                bottom: 10px;
                text-align: left;
                border: 1px solid #e9e9eb;
                background-color: #fff;
                padding: 18px;
                z-index: 29;
                border-radius: 4px;
                font-weight: 400;
                -webkit-box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1);
                box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1)
            }

            .size-buttons-sizeTip .size-buttons-sizeTipMeta p {
                margin: 0
            }

            .size-buttons-tipAndBtnContainer {
                margin: 10px 10px 10px 0
            }

            .size-buttons-tipAndBtnContainer:hover .size-buttons-sizeTip {
                visibility: visible
            }

            .size-buttons-size-buttons {
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                display: -webkit-box;
                display: -ms-flexbox;
                display: inline-flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                margin: 0;
                font-size: 13px;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                position: relative;
            }

            .size-buttons-size-buttons-error {
                padding-bottom: 10px;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-animation: size-buttons-shake .82s cubic-bezier(.36, .07, .19, .97) both;
                animation: size-buttons-shake .82s cubic-bezier(.36, .07, .19, .97) both;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                -webkit-perspective: 1000px;
                perspective: 1000px
            }

            @-webkit-keyframes size-buttons-shake {

                10%,
                90% {
                    -webkit-transform: translate3d(-1px, 0, 0);
                    transform: translate3d(-1px, 0, 0)
                }

                20%,
                80% {
                    -webkit-transform: translate3d(2px, 0, 0);
                    transform: translate3d(2px, 0, 0)
                }

                30%,
                50%,
                70% {
                    -webkit-transform: translate3d(-4px, 0, 0);
                    transform: translate3d(-4px, 0, 0)
                }

                40%,
                60% {
                    -webkit-transform: translate3d(4px, 0, 0);
                    transform: translate3d(4px, 0, 0)
                }
            }

            .size-buttons-size-error-message {
                color: #f16565;
                margin-top: 15px;
                display: block
            }

            .size-buttons-size-button-default {
                background-color: #fff;
                border: 1px solid #bfc0c6;
                border-radius: 50px;
                padding: 0;
                min-width: 35px;
                height: 35px;
                text-align: center;
                cursor: pointer;
                color: #282c3f;
                -webkit-box-flex: 0;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                position: relative;
            }

            .size-buttons-size-button {
                position: relative
            }

            .size-buttons-size-button-selected {
                border: 1px solid #ff3f6c;
                background-color: #fff;
                color: #ff3f6c !important
            }

            .size-buttons-size-button-disabled {
                color: #d5d6d9;
                border: 1px solid #d5d6d9;
                cursor: default;
                font-weight: 700;
                outline: none;
                overflow: hidden
            }

            .size-buttons-size-strike-hide {
                width: 0;
                height: 0
            }

            .size-buttons-size-strike-show {
                position: absolute;
                top: 50%;
                left: 0;
                width: 100%;
                height: 1px;
                background-color: #d5d6d9;
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            .size-buttons-big-size {
                min-height: 48px;
                min-width: 60px;
                border-radius: 50px;
                height: auto;
                width: auto;
                padding: 0 10px;
                font-weight: 700
            }

            .size-buttons-out-of-stock {
                color: #f16565
            }

            .size-buttons-size-button:hover {
                border: 1px solid #ff3f6c
            }

            .size-buttons-size-button:focus {
                outline: 0
            }

            .size-buttons-unified-size {
                margin: 0;
                font-size: 9px;
                padding: 0 1px;
                font-weight: 700;
            }

            .size-buttons-unified-size+.size-buttons-inventory-left {
                left: 7%;
                bottom: -3px
            }

            .size-buttons-sku-price {
                font-size: 12px;
                text-transform: capitalize;
                font-weight: 400;
                margin-top: 4px
            }

            .size-buttons-bodymeasure {
                color: #535665
            }

            .size-buttons-sizeChartInfo {
                color: #535665;
                margin-top: 5px;
                font-size: 12px
            }

            .size-buttons-sizeFitDesc {
                font-weight: 400;
                border: none
            }

            .size-buttons-measurementType {
                font-size: 14px;
                color: #282c3f
            }

            .size-buttons-measurementName {
                font-size: 14px;
                margin-left: 6px;
                font-weight: 700;
                color: #535665
            }

            .size-buttons-inventory-left {
                font-size: 12px;
                font-weight: 400;
                position: absolute;
                width: 100%;
                left: 0;
                width: 90%;
                left: 7%;
                background-color: #ff905a;
                color: #fff;
                border-radius: 2px;
                text-align: center
            }

            .size-buttons-inventory-left-hidden {
                visibility: hidden
            }

            .size-buttons-sizeButtonAsLink {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto
            }

            @media (min-width: 600px) {
                .size-buttons-size-buttons {
                    margin-bottom: 10px
                }
            }

            @media (min-width: 980px) {
                .size-buttons-size-chart {
                    top: 0;
                    right: 0
                }
            }

            .size-buttons-recoContainer {
                position: relative;
                clear: both
            }

            .size-buttons-recoWrapper {
                background: #fff0f4;
                padding: 9px 7px;
                width: 84%
            }

            .size-buttons-recoTextContainer {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex
            }

            .size-buttons-recoTextContainer.size-buttons-recoTextWithMoreProfiles {
                width: calc(100% - 90px)
            }

            .size-buttons-sizeRecoImg {
                width: 27px;
                height: 22px;
                margin-right: 14px
            }

            .size-buttons-recoContainerMobile {
                overflow: hidden
            }

            .size-buttons-recText {
                font-size: 16px;
                position: relative;
                margin: 8px
            }

            .size-buttons-moreProfilesWeb {
                position: absolute;
                right: 16px;
                top: 8px
            }

            .size-buttons-moreProfilesMobile {
                right: 20px;
                max-height: 0;
                -webkit-transition: max-height .6s cubic-bezier(0, 1, .5, 1);
                transition: max-height .6s cubic-bezier(0, 1, .5, 1)
            }

            .size-buttons-moreProfilesMobile .size-buttons-profileListHeader {
                position: absolute;
                right: 12px;
                top: 14px
            }

            .size-buttons-profileListHeader {
                cursor: pointer;
                padding: 10px 0;
                font-weight: 700;
                font-size: 16px;
                color: #ff3f6c
            }

            .size-buttons-sharpCorner {
                border-color: #fde3f3 transparent;
                border-style: solid;
                border-width: 10px 10px 0;
                width: 0;
                position: absolute;
                left: 22px;
                bottom: -8px
            }

            .size-buttons-profilesListWeb {
                margin: 0;
                width: 70px;
                background-color: #fff;
                -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, .13);
                box-shadow: 0 0 4px 0 rgba(0, 0, 0, .13);
                position: absolute;
                right: 0;
                top: 24px;
                padding: 8px 12px 4px;
                z-index: 2;
                display: none
            }

            .size-buttons-profilesListMobile {
                white-space: nowrap;
                overflow: auto;
                -webkit-transform: translateX(110%);
                transform: translateX(110%);
                -webkit-transition: -webkit-transform .6s cubic-bezier(0, 1, .5, 1);
                transition: -webkit-transform .6s cubic-bezier(0, 1, .5, 1);
                transition: transform .6s cubic-bezier(0, 1, .5, 1);
                transition: transform .6s cubic-bezier(0, 1, .5, 1), -webkit-transform .6s cubic-bezier(0, 1, .5, 1)
            }

            .size-buttons-profilesListMobile li {
                display: inline-block;
                border-radius: 50px;
                border: .5px solid #696b79;
                padding: 12px 18px;
                width: 65px;
                text-align: center;
                font-weight: 700;
                font-size: 15px;
                margin-right: 10px
            }

            .size-buttons-pNameHeader {
                color: #ff3f6c;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 90px;
                display: inline-block
            }

            .size-buttons-moreProfilesMobile.size-buttons-showProfiles {
                max-height: 50px
            }

            .size-buttons-moreProfilesMobile.size-buttons-showProfiles .size-buttons-profilesListMobile {
                -webkit-transform: translateX(0);
                transform: translateX(0)
            }

            .size-buttons-moreProfilesWeb:hover .size-buttons-profilesListWeb {
                display: inline-block
            }

            .size-buttons-profileItem {
                margin-bottom: 6px;
                cursor: pointer;
                color: #7e818c;
                font-size: 13px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis
            }

            .size-buttons-profileItem.size-buttons-selected {
                border: 1px solid #ff3f6c;
                background-color: #fff;
                color: #ff3f6c !important
            }

            .size-buttons-personalisedReco {
                width: 70%;
                display: inline-block;
                margin-top: 2px
            }

            .size-buttons-similarWrapper {
                margin: 0
            }

            .size-buttons-moreProfileSC {
                position: absolute;
                top: 12px;
                right: 16px
            }

            .size-buttons-viewSimilar {
                color: #ff3e6c;
                font-weight: 700;
                cursor: pointer
            }

            .size-buttons-tagInfoText {
                position: absolute;
                background: #fff;
                top: -78px;
                left: 0;
                width: 330px;
                padding: 8px 10px;
                display: none;
                border-radius: 6px;
                -webkit-box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1);
                box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1);
                text-align: left;
                border: 1px solid #e9e9eb;
                color: #535665
            }

            .size-buttons-tagInfoIcon {
                display: inline-block;
                border: 1px solid #7e808c;
                font-size: 12px;
                font-weight: 700;
                color: #fff;
                background: #7e808c;
                border-radius: 50%;
                width: 16px;
                height: 16px;
                text-align: center;
                cursor: pointer;
                margin-left: 10px
            }

            .size-buttons-tagInfoIcon:hover+.size-buttons-tagInfoText {
                display: block
            }

            .size-buttons-hide {
                display: none
            }

            .size-buttons-shakeText {
                -webkit-animation: size-buttons-shake .6s cubic-bezier(.36, .07, .19, .97) both;
                animation: size-buttons-shake .6s cubic-bezier(.36, .07, .19, .97) both;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                -webkit-perspective: 1000px;
                perspective: 1000px
            }

            .size-buttons-login {
                color: #ff3e6c;
                margin-left: 7px;
                font-weight: 700;
                cursor: pointer
            }

            .size-buttons-buttonContainer {
                position: relative
            }

            .size-buttons-reco-icon {
                display: inline-block;
                margin: 0 10px 0 4px;
                vertical-align: top
            }

            .size-buttons-sc-reco-txt {
                padding: 14px;
                background: -webkit-gradient(linear, left top, right top, from(#fde3f3), to(#fef9e5));
                background: linear-gradient(90deg, #fde3f3, #fef9e5);
                color: #282c3f
            }

            @keyframes size-buttons-shake {

                10%,
                90% {
                    -webkit-transform: translate3d(-1px, 0, 0);
                    transform: translate3d(-1px, 0, 0)
                }

                20%,
                80% {
                    -webkit-transform: translate3d(2px, 0, 0);
                    transform: translate3d(2px, 0, 0)
                }

                30%,
                50%,
                70% {
                    -webkit-transform: translate3d(-2px, 0, 0);
                    transform: translate3d(-2px, 0, 0)
                }

                40%,
                60% {
                    -webkit-transform: translate3d(2px, 0, 0);
                    transform: translate3d(2px, 0, 0)
                }
            }
        </style>
        <section class="browse-list-section mobviewsecone">
            <!-- category list custom -->

            <div class="container">

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                    <div id="owl-one" class="owl-carousel owl-theme">

                        @php
                            $category = DB::table('categories')
                                ->select('title', 'id', 'slug', 'photo')
                                ->where('is_parent', 0)
                                ->orderBy('headerorder', 'asc')
                                ->where('header', 'active')
                                ->where('status', 'active')
                                ->get();
                        @endphp

                        @foreach ($category as $c)
                            <div class="item">

                                <div class="category-item text-center">
                                    <a href="{{ url('product_list') . '/' . $c->slug }}" style="color:black !important;">
                                        <img src="{{ $c->photo }}" class="img-fluid menuimg" width="64"
                                            height="64" alt="">
                                        <h5 class="title fontsiz mt-0 mb-0">{{ $c->title }}</h5>

                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </section>
        <section class="page-header-area">
            <div class="container">
                <!-- style="margin-top:100px;" -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="page-header-st3-content">
                            <h2 class="page-header-title">Products</h2>
                        </div>
                    </div>

                    <div class="col-md-6 justify-content-end d-flex">
                        <div class="page-header-st3-content">
                            <ol class="breadcrumb justify-content-center justify-content-md-start">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Products</li>
                            </ol>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--== End Page Header Area Wrapper ==-->
        <!--== Start Product Area Wrapper ==-->

        <section class="padd-tb-30">

            <div class="container p-0">

                <div class="row">

                    <div class="col-12">

                        <div class="section-title text-center d-none">

                        </div>

                    </div>

                </div>

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">

                    @php  $rela_val=0; @endphp
                    @if (count($products) > 0)
                        @foreach ($products as $key => $product)
                            @php
                                $product_review = DB::table('product_reviews')
                                    ->select(DB::raw('SUM(rate) as price'), DB::raw('count(rate) as customer_count'))
                                    ->where('status', 'accept')
                                    ->where('product_id', $product->id)
                                    ->get();

                                $P_countreview = DB::table('product_reviews')
                                    ->where('status', 'accept')
                                    ->where('product_id', $product->id)
                                    ->get();

                                if ($product_review[0]->price != null && $product_review[0]->customer_count > 0) {
                                    $review = $product_review[0]->price / $product_review[0]->customer_count;
                                } else {
                                    $review = 0;
                                }

                                $variant = \App\Models\ProductVariant::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->first();

                                $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->where('in_stock', '!=', '0')
                                    ->first();

                                if (empty($newsizevariant1)) {
                                    $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)
                                        ->where('status', 'active')
                                        ->first();
                                }

                                $ADiscountpercent = 0;
                                $price = '';
                                $discount = '';

                                if ($newsizevariant1) {
                                    if ($product->discount_type == 'fixed') {
                                        $ADiscountpercent = $product->discount;
                                        $price = $newsizevariant1->regular_price - $product->discount;
                                        $discount = '';
                                    } else {
                                        if ($newsizevariant1->regular_price != 0) {
                                            $ADiscountpercent =
                                                ($newsizevariant1->regular_price / 100) * $product->discount;
                                        } else {
                                            $ADiscountpercent = 0;
                                        }
                                        $price = $newsizevariant1->regular_price - $ADiscountpercent;
                                        $discount = '%';
                                    }
                                }

                                $variants_array = \App\Models\ProductVariant::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->get();

                                $newsize = []; // Initialize the array outside the loop

                                if (!empty($variants_array)) {
                                    foreach ($variants_array as $vals) {
                                        $size = $vals->variants;
                                        array_push($newsize, $size); // Corrected the function name and variable order
                                    }
                                }

                                $size1 = '';
                                $size2 = '';
                                if (count($newsize) > 0) {
                                    $size1 = implode(',', $newsize);
                                    $size2 = str_replace(',,', ',', $size1);
                                }
                            @endphp

                            @php $relatedreview=($rela_val!=0) ? 2 : 0; @endphp

                            <div class="col-6 col-lg-4 col-md-6 col-sm-6 mb-1 mb-sm-9 searchgridcol">

                                <!--== Start Product Item ==-->

                                <div class="product-item single-productsBox">

                                    <div class="product-thumb product-image">

                                        <a class="d-block" href="{{ url('products') . '/' . $product->slug }}">

                                            <img src="{{ url((string) $aProductvariant_photo[$key]) }}" alt="Image-HasTech"
                                                class="home_product_img product-first-image">

                                            <img src="{{ url((string) $ahover_image_photo[$key]) }}"
                                                class="product-hover-image" alt="image">

                                        </a>

                                        <div class="product-status">

                                            @if ($aDiscountpercent[$key] != 0)
                                                <span>{{ number_format($ADiscountpercent, 2, '.', '') }}
                                                    <?php echo $discount; ?></span>
                                            @endif

                                        </div>

                                        <div class="product-action">

                                            <!-- <button type="button" class="product-action-btn action-btn-quick-view" data-product_id="{{ $product->id }}" data-slug="{{ $product->slug }}">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path><path d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z"></path></svg>

                                        </button> -->

                                            <button type="button" data-product_id="{{ $product->id }}"
                                                class="product-action-btn action-btn-wishlist wishlist_save icon_{{ $product->id }} add_towishlist_modal"
                                                data-bs-toggle="modal">

                                                @php
                                                    $currentUser =
                                                        auth()->guard('users')->user() ??
                                                        auth()->guard('guest')->user();
                                                @endphp
                                                @if ($currentUser && isset($iswishlist[$key]) && $iswishlist[$key] === 'yes')
                                                    <i class="fa fa-heart heart_icon{{ $product->id }}"
                                                        style="color:red;"></i>
                                                    <!--<svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="1em" height="1em" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">-->

                                                    <!--<g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="red" stroke="none">-->

                                                    <!--<path d="M1220 4684 c-418 -53 -754 -260 -982 -604 -232 -350 -297 -817 -167 -1205 56 -169 155 -341 269 -470 108 -122 2125 -2157 2151 -2171 36 -18 102 -18 138 1 31 15 2073 2079 2163 2185 378 445 428 1073 128 1596 -65 113 -128 194 -231 295 -182 180 -418 304 -677 356 -109 21 -383 24 -492 4 -214 -38 -436 -141 -615 -284 -27 -22 -116 -106 -197 -186 l-147 -145 -158 155 c-162 159 -255 235 -378 306 -115 67 -258 121 -395 148 -74 15 -343 27 -410 19z"/>-->

                                                    <!--</g>-->

                                                    <!--</svg>-->
                                                @else
                                                    <i class="fa fa-heart-o heart_icon{{ $product->id }}"></i>
                                                    <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.354 2.354-6.049-.002-8.416a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595zm6.791 1.61c1.563 1.571 1.564 4.025.002 5.588L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002z"></path></svg>-->
                                                @endif

                                            </button>

                                        </div>

                                    </div>

                                    <div class="product-info text-center">

                                        <h4 class="title"><a
                                                href="{{ url('products') . '/' . $product->slug }}">{{ $product->name }}</a>
                                        </h4>
                                        <?php
                                        $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
                                        ?>
                                        @if (count($newsizevariant) == 0)
                                            <div class="outofstock single"
                                                style="position: static;padding: 0px 39px;border: 1px solid #222e64;background: #222e64;color: #fff;width:100%;">
                                                <p>Out Of Stock</p>
                                            </div>
                                        @endif
                                        <div class="size-buttons-size-buttons">
                                            <?php
                          if(count($variants_array)>0){
                            foreach($variants_array as $vals){

                            if($vals->in_stock>0){
                                $class="";
                            }else{
                                $class="-disabled";
                            }
                          ?>
                                            <div class="size-buttons-tipAndBtnContainer">
                                                <div class="size-buttons-buttonContainer"><button
                                                        class="size-buttons-size-button<?php echo $class; ?> size-buttons-size-button-default"><span
                                                            class="size-buttons-size-strike-hide"></span>
                                                        <p class="size-buttons-unified-size">{{ $vals->variants }}</p>
                                                    </button></div>

                                            </div>
                                            <?php }} ?>

                                        </div>

                                        <!--      <div class="product-rating justify-content-center">

                                                <label class="rating-label align-items-center justify-content-center">

                                                    <p class="d-none">Ratings</p>

                                                    <input class="rating" max="5"

                                                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5"

                                                        style="--value:{{ $review }}" type="range" value="2.5" disabled>

                                                </label>

                                                <span class="rating-count">({{ count($P_countreview) }})</span>

                                            </div> -->

                                        <div class="prices d-flex justify-content-center  align-items-center">

                                            <div class="position-relative">

                                                <div>

                                                    @if ($aDiscountpercent[$key] != 0)
                                                        <span class="price-old">
                                                            ₹{{ number_format($newsizevariant1->regular_price, 2, '.', '') }}</span>
                                                    @endif
                                                    <span
                                                        class="price"><span>₹</span>{{ number_format($price, 2, '.', '') }}</span>
                                                </div>
                                                <!-----
                                                 @if ($product->stock > 0)
    <button class="add-to-cart add_tocart_modal" type="button" data-product_id="{{ $product->id }}" class="action-btn-cart"

                                                    data-bs-toggle="modal" data-bs-target="#">

                                                    Add to cart

                                                </button>
    @endif
                                                ---->

                                            </div>

                                            <div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!--== End prPduct Item ==-->

                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-area ltn__section-title-2 text-center mb-5">
                                    <img src="{{ asset('frontend/img/no_products.png') }}" alt="no-product"
                                        style="width:100px;height:100px;">
                                    <h5 class="section-title about-us-title" style="font-size: 34px;">No products found
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- End products modal -->

                </div>

            </div>

        </section>

        <!--== End Product Banner Area Wrapper ==-->
        {{-- <section class="">
        <div class="container">
           @php
           $catcount=0;
           @endphp
            @foreach ($category as $c)
            @php
            $products=DB::table('products')->where('cat_id',$c->id)->where('status','active')->get();
            @endphp
            <div class="row justify-content-between flex-xl-row-reverse" id="cat_{{ $c->id }}">
                <div class="padding-top text-center arrivals">
                    <h2 class="title">{{$c->title}}</h2>
                    <!-- <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam, purus sit amet luctus venenatis</p> -->
                </div>
                <div class="col-xl-12">
                    <div class="row g-3 g-sm-6">
                        @foreach ($products as $p)
                        @php
                        $product_reviews=DB::table('product_reviews')->select(DB::raw("SUM(rate) as price"),DB::raw("count(rate) as customer_count"))->where('status','accept')->where('product_id',$p->id)->get();
                        if($product_reviews[0]->price != NULL && $product_reviews[0]->customer_count > 0){
                        $reviews=$product_reviews[0]->price / $product_reviews[0]->customer_count;
                        }else{
                        $reviews=0;
                        }
                        $rev=DB::table('product_reviews')->where('product_id',$p->id)->where('status','accept')->get();
                        $variant_val=App\Models\ProductVariant::where('product_id',$p->id)->orderBy('id','desc')->first();
                        $product_variant=DB::table('product_variant')->where('product_id',$p->id)->orderBy('id','desc')->first();
                        @endphp
                        <div class="col-12 col-lg-4 col-xl-4 col-md-6 mb-4 mb-sm-8">
                            <!--== Start Product Item ==-->
                            <div class="product-item product-st3-item">
                                <div class="product-thumb">
                                    <a class="d-block" href="{{url('products').'/'.$p->slug}}">
                                        <img src="{{url((string)$p->photo)}}" width="370" height="450" alt="Image-HasTech">
                                    </a>
                                    <span class="flag-new">new</span>
                                    <!-- <div class="product-action">
                                        <button type="button" class="product-action-btn action-btn-quick-view" data-bs-toggle="modal" data-bs-target="#action-QuickViewModal_{{$p->id}}">
                                            <i class="fa fa-expand"></i>
                                        </button>
                                        <button type="button" data-sale_price="{{$categorysale_price[$catcount]}}" data-product-id="{{$p->id}}" class="product-action-btn action-btn-cart cart_save" data-bs-toggle="modal" data-bs-target="#">
                                            <span>Add to cart</span>
                                        </button>
                                        <button type="button" data-product-id="{{$p->id}}" class="product-action-btn action-btn-wishlist wishlist_save icon_{{$p->id}}" data-bs-toggle="modal">
                                            @if ($wish_cnt > 0)
                                            <i class='fa fa-heart' style='color: red'></i>
                                            @else
                                            <i class="fa fa-heart-o"></i>
                                            @endif
                                        </button>
                                    </div> -->
                                </div>
                                <section>
                                <div class="product-action">
                                        <button type="button" class="product-action-btn action-btn-quick-view" data-bs-toggle="modal" data-bs-target="#action-QuickViewModal_{{$p->id}}">
                                            <i class="fa fa-expand"></i>
                                        </button>
                                        <button type="button" data-sale_price="{{$categorysale_price[$catcount]}}" data-product-id="{{$p->id}}" class="product-action-btn action-btn-cart cart_save" data-bs-toggle="modal" data-bs-target="#">
                                            <span>Add to cart</span>
                                        </button>
                                        <button type="button" data-product-id="{{$p->id}}" class="product-action-btn action-btn-wishlist wishlist_save icon_{{$p->id}}" data-bs-toggle="modal">
                                            @if ($wish_cnt > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412L12 21.414l8.207-8.207c2.354-2.353 2.355-6.049-.002-8.416z"></path></svg>
                                            @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412L12 21.414l8.207-8.207c2.354-2.353 2.355-6.049-.002-8.416z"></path></svg>
                                            @endif
                                        </button>
                                    </div>
                                  </section>
                                <div class="product-info">
                                    <!-- <div class="product-rating">
                                        <label class="rating-label">
                                            <p>{{$reviews}} Ratings</p>
                                            <input class="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:{{$reviews}}" type="range" value="2.5" disabled>
                                        </label>
                                    </div> -->
                                    <h4 class="title"><a href="{{url('products').'/'.$p->slug}}">{{$p->title}}</a></h4>
                                    <div class="prices">
                                        <span class="price">₹{{$categorysale_price[$catcount]}}</span>
                                        <span class="price-old">{{$product_variant->regular_price}}</span>
                                    </div>
                                </div>
                                <div class="product-action-bottom">
                                    <button type="button" class="product-action-btn action-btn-quick-view" data-bs-toggle="modal" data-bs-target="#action-QuickViewModal_{{$p->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path><path d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z"></path></svg>
                                    </button>
                                    <button type="button" class="product-action-btn action-btn-wishlist wishlist_save" data-bs-toggle="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412L12 21.414l8.207-8.207c2.354-2.353 2.355-6.049-.002-8.416z"></path></svg>
                                    </button>
                                    <button type="button" class="product-action-btn action-btn-cart cart_save" data-product-id="{{$p->id}}" data-bs-toggle="modal">
                                        <span>Add to cart</span>
                                    </button>
                                </div>
                            </div>
                            <!--== End prPduct Item ==-->
                        </div>
                        @php
                            $catcount ++;
                        @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section> --}}
    </main>
    </body>

    </html>
@endsection
@section('script')
@endsection
