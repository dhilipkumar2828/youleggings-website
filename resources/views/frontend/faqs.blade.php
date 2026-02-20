@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->

        <nav aria-label="breadcrumb" class="breadcrumb-style1">

            <div class="container">

                <ol class="breadcrumb justify-content-center">

                    <li class="breadcrumb-item"><a href="{{ url('index') }}">Home</a></li>

                    <li class="breadcrumb-item active" aria-current="page">Faq</li>

                </ol>

                <!-- <h2 class="page-header-title">Privacy Policy</h2> -->

            </div>

        </nav>

        <!--== Start Faq Area Wrapper ==-->

        <section class="faq-area">

            <div class="container">

                <div class="row flex-xl-row-reverse">

                    <div class="col-lg-6 col-xl-7">

                        <div class="faq-thumb">

                            <img src="{{ asset('frontend/img/photos/faq-home.webp') }}" width="601" height="368"
                                alt="Image">

                        </div>

                    </div>

                    <div class="col-lg-6 col-xl-5">

                        <div class="faq-content">

                            <div class="faq-text-img"><img src="{{ asset('frontend/img/photos/faq.webp') }}" width="199"
                                    height="169" alt="Image"></div>

                            <h2 class="faq-title">Frequently Asked Questions</h2>

                            <div class="faq-line"></div>

                            <p class="faq-desc">It's tough to establish one all-encompassing template for your About page —
                                there are so many ways you can go about telling your company story. The good news is, there
                                are some tried-and-true steps to get you started.</p>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-12">

                        <h2>Shopping information</h2>

                        <div class="accordion" id="FaqAccordion">

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading1">

                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">

                                        Establish a mission statement.

                                    </button>

                                </h2>

                                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>Your About page can and will be more comprehensive than a single mission
                                            statement, but to draw people in, you need to succinctly state your goal in the
                                            industry upfront. What is your business here to do? Why should your website
                                            visitors care? This information will give the reader something to remember about
                                            your company long after they leave your website.</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading2">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">

                                        Outline your company story.

                                    </button>

                                </h2>

                                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>Every business has a story to tell. Even if you're running a start-up, you might
                                            not have a long history of changes and growth (yet), but it's a nice touch to
                                            talk about how you got to where you are on the About page. So, isolate the
                                            milestones before your company's founding, and use them to give readers some
                                            backstory on your current venture.</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading3">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">

                                        Reveal how you've evolved

                                    </button>

                                </h2>

                                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>There's no shame in admitting how your business strategy — or even your way of
                                            thinking — has changed since you began. In fact, these evolutions can improve
                                            the story you tell to website visitors.<br>

                                            About pages are perfect spaces to talk about where you started, how you've
                                            grown, and the ideals that have helped your organization mature. Use these
                                            moments to further your company story and show people that you're always ready
                                            to change and adapt to the needs of your industry.</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading4">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">

                                        State your "aha!" moment

                                    </button>

                                </h2>

                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>Every good company was founded on an idea — something the current marketplace
                                            might not yet offer. What was your idea? Use this "Aha!" moment as a pivot point
                                            when telling your company story. What was a challenge you faced while developing
                                            your company? How did this challenge or discovery shape what you are today?</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading5">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">

                                        Explain who you serve.

                                    </button>

                                </h2>

                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>As much as you want as many eyeballs on your About page as possible, you won't do
                                            business with every single one of them. That's why you must identify and mention
                                            your core customer. This lets your visitors know what your business is dedicated
                                            to helping them meet their needs and goals.</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading6">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">

                                        Explain what you're offering them.

                                    </button>

                                </h2>

                                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>As you're explaining who you serve, make it clear what it is you're offering.
                                            Companies often generalize their products or services in the website copy,
                                            making it hard to understand what it is the customer is actually paying for.
                                            Sometimes, businesses are afraid that the literal explanations of their products
                                            aren't interesting enough or will sound unappealing in writing. And that's a
                                            fair concern.<br>

                                            However, investing just a sentence or two into telling your potential customers
                                            exactly what they'll receive can keep them on your website for longer and get
                                            them interested in learning more.</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading7">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">

                                        Cite examples of clients you've served.

                                    </button>

                                </h2>

                                <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>Got some loyal customers in your portfolio? Use your About page to let the world
                                            know who already trusts and benefits from your work. A great way to showcase
                                            this is through a case study.<br>

                                            Knowing about your company's past successes can influence your prospects'
                                            purchasing decisions because they will be able to envision their success in the
                                            success of your past customers.</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading8">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">

                                        Describe your values.

                                    </button>

                                </h2>

                                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>Customers want to be treated like human beings. For that to happen, they need to
                                            feel that they're being served by human beings. When finishing your About page,
                                            describe who you are as a person or a team, and what your personal values are.
                                            What's your company culture like? What bigger picture in life drives your
                                            business?<br>

                                            Keep in mind a secondary audience of your company's About page consists of your
                                            future employees. This is another reason describing your personal values is a
                                            good idea — the key to your job candidates' hearts is to show them you have one
                                            too.</p>

                                    </div>

                                </div>

                            </div>

                            <div class="accordion-item">

                                <h2 class="accordion-header" id="heading9">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">

                                        What Shipping Methods Are Available?

                                    </button>

                                </h2>

                                <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9"
                                    data-bs-parent="#FaqAccordion">

                                    <div class="accordion-body">

                                        <p>Roactively procrastinate market-driven niche markets and robust value.
                                            Appropriately harness multidisciplinary scenarios whereas diverse catalysts for
                                            change. Energistically provide access to future-proof deliverables and
                                            distinctive manufactured products.Proactively procrastinate market-driven niche

                                        </p>

                                    </div>

                                </div>

                            </div>

                            <!-- <div class="accordion-item">

                                        <h2 class="accordion-header" id="heading8">

                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">

                                                What Shipping Methods Are Available?

                                            </button>

                                        </h2>

                                        <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#FaqAccordion">

                                            <div class="accordion-body">

                                                <p>Roactively procrastinate market-driven niche markets and robust value. Appropriately harness multidisciplinary scenarios whereas diverse catalysts for change. Energistically provide access to future-proof deliverables and distinctive manufactured products.Proactively procrastinate market-driven niche

                                                </p>

                                            </div>

                                        </div>

                                    </div> -->

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!--== End Faq Area Wrapper ==-->

    </main>
@endsection

@section('script')
@endsection
