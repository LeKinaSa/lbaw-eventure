<? include_once('../templates/header.php'); ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active">Event metrics</li>
        </ol>
    </nav>

    <section id="eventMetrics">
        <h3>Event metrics</h3>

        <nav>
            <div class="nav nav-tabs" id="eventMetricsTabs" role="tablist">
                <button class="nav-link active" id="overviewEventsTab" data-bs-toggle="tab" data-bs-target="#overviewEvents" type="button" role="tab" aria-controls="overviewEvents" aria-selected="true">
                    Overview
                </button>
                <button class="nav-link" id="categoryTab" data-bs-toggle="tab" data-bs-target="#category" type="button" role="tab" aria-controls="category" aria-selected="false">
                    Category
                </button>
                <button class="nav-link" id="typeTab" data-bs-toggle="tab" data-bs-target="#type" type="button" role="tab" aria-controls="type" aria-selected="false">
                    Type
                </button>
                <button class="nav-link" id="visibilityTab" data-bs-toggle="tab" data-bs-target="#visibility" type="button" role="tab" aria-controls="visibility" aria-selected="false">
                    Visibility
                </button>
            </div>
        </nav>

        <div class="tab-content p-2" id="eventMetricsContent">
            <div class="tab-pane fade show active" id="overviewEvents" role="tabpanel" aria-labelledby="overviewEventsTab">
                Events overview
            </div>

            <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="categoryTab">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Category</th>
                            <th>Events</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Video games</td>
                            <td>233</td>
                            <td>46.2%</td>
                        </tr>
                        <tr>
                            <td>Board games</td>
                            <td>139</td>
                            <td>27.6%</td>
                        </tr>
                        <tr>
                            <td>Card games</td>
                            <td>64</td>
                            <td>12.7%</td>
                        </tr>
                        <tr>
                            <td>Other</td>
                            <td>68</td>
                            <td>13.5%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="type" role="tabpanel" aria-labelledby="typeTab">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Type</th>
                            <th>Events</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>In person</td>
                            <td>133</td>
                            <td>26.4%</td>
                        </tr>
                        <tr>
                            <td>Mixed</td>
                            <td>105</td>
                            <td>20.8%</td>
                        </tr>
                        <tr>
                            <td>Virtual</td>
                            <td>266</td>
                            <td>52.8%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="visibility" role="visibility" aria-labelledby="visibilityTab">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Visibility</th>
                            <th>Events</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Public</td>
                            <td>316</td>
                            <td>62.7%</td>
                        </tr>
                        <tr>
                            <td>Private</td>
                            <td>188</td>
                            <td>37.3%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<? include_once('../templates/footer.php'); ?>