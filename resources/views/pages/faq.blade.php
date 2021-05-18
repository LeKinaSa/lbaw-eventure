@extends('layouts.app')

@section('content')

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">FAQ</li>
        </ol>
    </nav>

    <section id="frequentlyAskedQuestions" class="container">
        <h1 class="text-center mb-3">Frequently Asked Questions</h1>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                        How do I join an event?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        To join an event, you first need to create an account on the website. Once you are authenticated, 
                        after navigating to the page of the event you want to join, click the request to participate button.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse1">
                        How do I invite someone do my private event?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        To invite someone to your private event, click the invitations link in the event's page. Afterwards, you can 
                        invite them by entering their username or email.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse1">
                        How do I post match results?
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Navigate to your event's page and then to the results page. Click the green "plus" button to add a new match.
                        Afterwards you can fill in the match details.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
