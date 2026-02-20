@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <style>
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
            min-width: 30px;
            height: 30px;
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
            font-size: 13px;
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
            text-align: left;
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
            background: #364958;
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
            background-image: url('frontend/img/banner-praaya.png')
        }

        @media (max-width: 767px) {
            owl-carousel .owl-nav button.owl-prev {
                position: absolute;
                left: 0 !important;
                top: 60px !important;
                font-size: 39px !important;
            }

            .header-logo.ml-10 a {
                font-size: 21px !important;
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

        .size-buttons-size-container {
            margin: 10px 0 24px
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
            margin: 10px 0px 10px 4px;
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
        integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <main class="main-content">

        <!--== Start Hero Area Wrapper ==-->

        <section class="hero-two-slider-area position-relative ">

            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-indicators">

                    @foreach ($banners as $i => $b)
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $i }}"
                            class="@if ($i == 0) active @endif" aria-current="true"
                            aria-label="Slide {{ $i }}"></button>
                    @endforeach

                </div>

                <div class="carousel-inner">

                    @foreach ($banners as $i => $b)
                        <?php
                if($b->link!='0'){
                    ?>
                        <a href="product_list/{{ $b->link }}"
                            class="carousel-item @if ($i == 0) active @endif"
                            style="background:url('{{ asset($b->photo) }}') no-repeat;"></a>
                        <?php
                }else{
                    ?>
                        <div class="carousel-item @if ($i == 0) active @endif"
                            style="background:url('{{ asset($b->photo) }}') no-repeat;"></div>
                        <?php
                }
                ?>
                    @endforeach

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">

                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                    <span class="visually-hidden">Previous</span>

                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">

                    <span class="carousel-control-next-icon" aria-hidden="true"></span>

                    <span class="visually-hidden">Next</span>

                </button>

            </div>

        </section>

        <?php
    $flatoffers = DB::table('coupon')
        ->where('offer_details', 1)
        ->where('status', 'active')
        ->first();

    if(!empty($flatoffers)){
    ?>
        <!--<div class="offer">-->
        <!--   <div class="offer-text">FLAT ₹{{ $flatoffers->flatofferamount }} OFF </div>-->
        <!--   <p>Flat ₹{{ $flatoffers->flatofferamount }} Off on Orders above ₹{{ $flatoffers->offeramountabove }}\-</p>-->
        <!--   <div class="offer-code" onclick="copyToClipboard('250OFF')">Use Code: <span>{{ $flatoffers->coupon_code }}</span>-->
        <!--   </div>-->
        <!-- </div>-->

        <div class="offer mob">
            <p>FLAT ₹{{ $flatoffers->flatofferamount }} OFF / Flat ₹{{ $flatoffers->flatofferamount }} Off on Orders above
                ₹{{ $flatoffers->offeramountabove }}\- Use Code: {{ $flatoffers->coupon_code }} </p>
        </div>
        </div>
        <?php } ?>
        <!--== End Hero Area Wrapper ==-->
        <section class="browse-list-section">
            <!-- category list custom -->

            @php
                $browseCategories = DB::table('categories')
                    ->where('category', 'active')
                    ->where('status', 'active')
                    ->where('parent_id', null)
                    ->orderBy('id', 'desc')
                    ->limit(6)
                    ->get();
            @endphp

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-title text-left">
                            <h3 class="title fontsiz mt-5 mb-3">Browse <span>Our Categories</span></h3>
                        </div>
                    </div>
                </div>

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                    <div id="owl-one" class="owl-carousel owl-theme">
                        @foreach ($browseCategories as $categoryList)
                            @if (!empty($categoryList->photo))
                                <div class="item">

                                    <div class="category-item text-center">
                                        <a href="{{ url('product_list') . '/' . $categoryList->slug }}">
                                            <img src="{{ $categoryList->photo }}" alt="{{ $categoryList->title }}"
                                                loading="lazy"
                                                style="width: 300px; height: 200px; object-fit: cover;border-radius: 15PX;"
                                                class="img-fluid mb-3">
                                            <h5 class="title fontsiz mt-0 mb-0">{{ $categoryList->title }}</h5>

                                        </a>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </section>

        <!-- custom offer list -->

        <!-- custom top products list -->
        <section class="top-product-list-section  mb-5">
            @php

                $productCategories = DB::table('products as p')
                    ->leftjoin('product_variants  as v', 'v.product_id', '=', 'p.id')
                    ->where('p.status', '=', 'active')
                    ->where('p.deleted_at', '=', null)
                    ->where('v.in_stock', '>', '0')
                    ->orderBy('p.id', 'desc')
                    ->select('p.*')
                    ->groupBy('p.id')
                    ->limit(8)
                    ->get();

                //  $productCategories = DB::table('products as p')->where('p.status', 'active')->orderBy('p.id', 'desc')->orderBy('p.stock', 'desc')->limit(8)->get();

                // echo "<pre>";
                //print_r($productCategories);

            @endphp

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-title text-left">
                            <h3 class="title fontsiz mt-5 mb-3">New <span>Arrivals</span></h3>
                        </div>
                    </div>
                </div>

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                    @foreach ($productCategories as $product)
                        @php
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
                                    if (
                                        $newsizevariant1->regular_price != 0 &&
                                        $newsizevariant1->regular_price != 'null'
                                    ) {
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

                            $aSaleprice = Helper::fetchSalePrice(
                                $newsizevariant1 ? $newsizevariant1->regular_price : 0,
                                $product->tax_id,
                                $product->discount,
                                $product->discount_type,
                            );
                        @endphp
                        @if (!empty($variant->photo))
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-4 text-center">
                                <div class="product-card">
                                    <div class="custom-product-image">
                                        <a href="{{ url('products') . '/' . $product->slug }}">
                                            <img src="{{ $variant->photo }}" loading="lazy" alt="{{ $product->name }}">
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-name">{{ $product->name }}</h5>

                                        <div class="price-info">
                                            @if ($product->discount > 0)
                                                <div class="product-price">

                                                    <div class="discounted-price">

                                                        <span><i style="font-size:14px"
                                                                class="fa">&#xf156;</i>{{ $price }}</span>
                                                    </div>

                                                    <div class="original-price">
                                                        <span><i style="font-size:14px"
                                                                class="fa">&#xf156;</i>{{ $newsizevariant1->regular_price }}</span>
                                                    </div>

                                                    <div class="product-discount">
                                                        <p>{{ $product->discount }}{{ $discount }} Off</p>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="product-price"><i style="font-size:14px"
                                                        class="fa">&#xf156;</i>{{ $newsizevariant1->regular_price }}
                                                </p>
                                            @endif

                                        </div>
                                        <?php
                                        $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '>', '0')->get();
                                        ?>
                                        @if (count($newsizevariant) == 0)
                                            <div class="outofstock single home"
                                                style="border: 1px solid #222e64;background: #222e64;color: #fff;width:100%;">
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
                                                        class="size-buttons-size-button<?php echo $class; ?> size-buttons-size-button-default"
                                                        data-product-stock="{{ $vals->in_stock }} Stocks Available"
                                                        data-tippy-content="{{ $vals->in_stock }} Stocks Available"><span
                                                            class="size-buttons-size-strike-hide"></span>
                                                        <p class="size-buttons-unified-size">{{ $vals->variants }}</p>
                                                    </button></div>

                                            </div>
                                            <?php }} ?>

                                        </div>

                                        <!--    <ul class="size">
                      <?php
                  if(count($newsize)>0){
                    foreach($newsize as $size){

                        $size1 =  str_replace(',', '', $size);

                  ?>
                      <li>{{ $size1 }}</li>
                      <?php }} ?>
                  </ul>   -->

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            </div>
        </section>

        <section class="offers-list-section mt-5 mb-5" style="background:#2319420a">
            @php
                $offerCategories = DB::table('categories')
                    ->where('offers', 'active')
                    ->where('parent_id', null)
                    ->where('status', 'active')
                    ->orderBy('id', 'desc')
                    ->limit(4)
                    ->get();
            @endphp

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-title text-left">
                            <h3 class="title fontsiz mt-5 mb-3"> New <span>Offers</span></h3>
                        </div>
                    </div>
                </div>

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">

                    @foreach ($offerCategories as $offers)
                        @if (!empty($offers->photo))
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                                <div class="category-item text-center">
                                    <a href="{{ url('product_list') . '/' . $offers->slug }}">
                                        <img src="{{ asset($offers->photo) }}" loading="lazy"
                                            alt="{{ $offers->title }}"
                                            style="width: 300px; height: 300px; object-fit: cover;border-radius: 15PX;"
                                            class="img-fluid mb-3">
                                        <h5 class="title fontsiz mt-0 mb-0">{{ $offers->title }}</h5>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            </div>
        </section>

        <div class="parallax-section parallax1">

            <section id="testimonials">
                <!--heading--->
                <div class="testimonial-heading">
                    <p>Client Says</p>

                    <a href="{{ url('reviews') }}">
                        <h6 style="color:white"> Write your Reviews
                            <i class="fa fa-pencil"></i>
                        </h6>
                    </a>

                </div>
                <!--testimonials-box-container------>

                <div class="container">

                    <div class="testimonial-box-container">
                        <div id="owl-two" class="owl-carousel owl-theme">

                            @foreach ($allreviews as $reviews)
                                <!--BOX-1-------------->
                                <div class="item">
                                    <div class="testimonial-box">
                                        <!--top------------------------->
                                        <div class="box-top">
                                            <!--profile----->
                                            <div class="profile">
                                                <!--img---->

                                                <!--name-and-username-->
                                                <div class="name-user">
                                                    <strong>{{ $reviews->name }}</strong>
                                                    <span>Happy Client</span>
                                                </div>
                                            </div>
                                            <!--reviews------>
                                            <div class="reviews">
                                                {!! str_repeat('<span><i class="fa fa-star"></i></span>', $reviews->rate) !!}
                                                {!! str_repeat('<span><i class="fa fa-star-o"></i></span>', 5 - $reviews->rate) !!}

                                            </div>
                                        </div>
                                        <!--Comments---------------------------------------->
                                        <div class="client-comment">
                                            <p>

                                                {{ $reviews->feedback }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!--BOX-3-------------->
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- custom youtube list -->
        <section class="youtube-list-section ">
            <!-- category list custom -->

            @php
                $youtubeCategories = DB::table('youtube')
                    ->where('status', 'active')
                    ->orderBy('id', 'desc')
                    ->limit(3)
                    ->get();
            @endphp

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-title text-left">
                            <h3 class="title fontsiz mt-5 mb-3">Know <span>Prrayasha Collections</span></h3>
                        </div>
                    </div>
                </div>

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">

                    @foreach ($youtubeCategories as $youtube)
                        @if (!empty($youtube->photo))
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                                <div class="category-item text-center">
                                    <a href="{{ $youtube->url }}" target="_blank" class="video-link">

                                        <img src="{{ asset($youtube->photo) }}" loading="lazy"
                                            alt="{{ $youtube->photo }}"
                                            style="width: 300px; height: 200px; object-fit: cover;border-radius: 15PX;"
                                            class="img-fluid mb-3">
                                        <div class="play-button">
                                            <i class="fa fa-play-circle"></i>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            </div>
        </section>

        <!--== scroll bg ==-->

        <!--== Start Product Area Wrapper ==-->

        <!--== scroll bg ==-->

        <section class="instagram-area pt-100 d-none">

            <div class="container">

                <div class="row mb-5">

                    <div class="col-lg-12 text-center pb-5">

                        <a href="#" target="_blank" class="text-uppercase fw-light"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                <path
                                    d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z">
                                </path>
                                <circle cx="16.806" cy="7.207" r="1.078"></circle>
                                <path
                                    d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z">
                                </path>
                            </svg> Follow us on

                            Instagram Feed

                        </a>

                    </div>

                </div>

            </div>

            <div class="owl-carousel owl-theme instaowl">

                <!-- insta repeat -->

                <div class="item">

                    <div class="single-instagram-post">

                        <img
                            src="https://kiruthika.oceansoftwares.in/krishna/1/assets/img/products/315754001_1362769924463452_8889021110453051560_n.jpg" />

                        <span class="instaicons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                <path
                                    d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z">
                                </path>
                                <circle cx="16.806" cy="7.207" r="1.078"></circle>
                                <path
                                    d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z">
                                </path>
                            </svg></span>

                        <a href="#" target="_blank" class="link-btn"></a>

                    </div>

                </div>

                <!-- insta repeat -->

                <!-- insta repeat -->

                <div class="item">

                    <div class="single-instagram-post">

                        <img
                            src="https://kiruthika.oceansoftwares.in/krishna/1/assets/img/products/316136008_2394655777350955_7616695352540162676_n.jpg" />

                        <span class="instaicons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                <path
                                    d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z">
                                </path>
                                <circle cx="16.806" cy="7.207" r="1.078"></circle>
                                <path
                                    d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z">
                                </path>
                            </svg></span>

                        <a href="#" target="_blank" class="link-btn"></a>

                    </div>

                </div>

                <!-- insta repeat -->

                <!-- insta repeat -->

                <div class="item">

                    <div class="single-instagram-post">

                        <img
                            src="https://kiruthika.oceansoftwares.in/krishna/1/assets/img/products/316120734_1331499004347094_1570003295056820631_n.jpg" />

                        <span class="instaicons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                <path
                                    d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z">
                                </path>
                                <circle cx="16.806" cy="7.207" r="1.078"></circle>
                                <path
                                    d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z">
                                </path>
                            </svg></span>

                        <a href="#" target="_blank" class="link-btn"></a>

                    </div>

                </div>

                <!-- insta repeat -->

                <!-- insta repeat -->

                <div class="item">

                    <div class="single-instagram-post">

                        <img
                            src="https://kiruthika.oceansoftwares.in/krishna/1/assets/img/products/316180237_1095068017863297_3278486297116119573_n.jpg" />

                        <span class="instaicons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                <path
                                    d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z">
                                </path>
                                <circle cx="16.806" cy="7.207" r="1.078"></circle>
                                <path
                                    d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z">
                                </path>
                            </svg></span>

                        <a href="#" target="_blank" class="link-btn"></a>

                    </div>

                </div>

                <!-- insta repeat -->

            </div>

        </section>

        <!--== scroll bg ==-->

        <div class="modal fade" id="aptumo-billing-research">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header"
                        style="background:#f6b33d -moz-linear-gradient(center top , #f6b33d 5%, #d29105 100%) repeat scroll 0 0;">

                        <a class="close" data-dismiss="modal">×</a>

                        <h3 style="color:#ffffff;">Please Note:</h3>

                    </div>

                    <div class="modal-body">

                        <p>You can put whatever text you want in here... or form or whatever you want..</p>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Modal Start -->

    <div id="myModal" class="modal fade">

        <div class="modal-dialog" id="dialogue">

            <div class="modal-content" id="button-content">

                <button type="button" class="btn-close" data-bs-dismiss="modal">

                    <span class="fa fa-close"></span>

                </button>

                <div class="modal-header" id="modal-head">

                    <div class="modal-image" id="mob-img">

                        <img src="{{ asset('frontend/img/brand-logo/banner3.jpg') }}">

                    </div>

                    <div class="modal-body" id="para-text">

                        <h5 class="modal-title">Tulia</h5>

                        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

                        <p>ENJOY 10% OFF</p>

                        <form>

                            <!-- <div class="form-group">

                                    <input type="text" class="form-control" placeholder="Name">

                                </div> -->

                            <div class="form-group">

                                <input type="email" class="form-control" id="subscriber_email"
                                    placeholder="Email Address">

                                <div id="email_err" style="color:red;display:none"> Invalid Email</div>

                            </div>

                            <button type="button" id="subscribe_submit" class="btn btn-primary">SUBSCRIBE</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal End -->

    </div>

    <!--== Wrapper End ==-->

    <!-- JS Vendor, Plugins & Activation Script Files -->

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="banner-box-footer">

                    <img src="{{ !empty($advertisement->photo) ? $advertisement->photo : '' }}" loading="lazy"
                        alt="">

                </div>

            </div>

        </div>

    </div>

    @php

        /*echo '

<pre>';a

var_dump(\Session::get('subsform_shown'));

exit;*/
    @endphp

    @if (!Session::get('subsform_shown', false))
        <script>
            $(document).ready(function() {

                document.getElementById('SearchInput').value = '';
            });
            window.addEventListener('popstate', function(event) {
                // Clear the search input field when the back button is pressed
                document.getElementById('SearchInput').value = '';
            });

            // On page load, clear the search input if the URL doesn't have the product_name parameter
            document.addEventListener('DOMContentLoaded', function() {
                // Check if the 'product_name' parameter exists in the URL
                if (window.location.search.indexOf('product_name') === -1) {
                    document.getElementById('SearchInput').value = ''; // Clear the input field
                }
            });
            if (window.location.search.indexOf('product_name') !== -1) {
                history.replaceState(null, '', '/'); // Removes query params from the URL
            }
        </script>
    @endif

    @php

        Session::put('subsform_shown', true);

    @endphp
@endsection

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

@section('script')
@endsection
