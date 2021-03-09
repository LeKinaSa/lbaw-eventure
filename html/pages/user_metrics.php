<? include_once('../templates/header.php'); ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active">User metrics</li>
        </ol>
    </nav>

    <section id="userMetrics">
        <h3>User metrics</h3>
        
        <nav>
            <div class="nav nav-tabs" id="userMetricsTabs" role="tablist">
                <button class="nav-link active" id="overviewUsersTab" data-bs-toggle="tab" data-bs-target="#overviewUsers" type="button" role="tab" aria-controls="overviewUsers" aria-selected="true">
                    Overview
                </button>
                <button class="nav-link" id="ageTab" data-bs-toggle="tab" data-bs-target="#age" type="button" role="tab" aria-controls="age" aria-selected="false">
                    Age
                </button>
                <button class="nav-link" id="genderTab" data-bs-toggle="tab" data-bs-target="#gender" type="button" role="tab" aria-controls="gender" aria-selected="false">
                    Gender
                </button>
                <button class="nav-link" id="countryTab" data-bs-toggle="tab" data-bs-target="#country" type="button" role="tab" aria-controls="country" aria-selected="false">
                    Country
                </button>
            </div>
        </nav>

        <div class="tab-content p-2" id="userMetricsContent">
            <div class="tab-pane fade show active" id="overviewUsers" role="tabpanel" aria-labelledby="overviewUsersTab">
                Users overview
            </div>
            <div class="tab-pane fade" id="age" role="tabpanel" aria-labelledby="ageTab">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Age group</th>
                            <th>Users</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Under 18</td>
                            <td>184</td>
                            <td>10.3%</td>
                        </tr>
                        <tr>
                            <td>18-24</td>
                            <td>587</td>
                            <td>32.9%</td>
                        </tr>
                        <tr>
                            <td>25-34</td>
                            <td>688</td>
                            <td>38.6%</td>
                        </tr>
                        <tr>
                            <td>35-44</td>
                            <td>177</td>
                            <td>9.9%</td>
                        </tr>
                        <tr>
                            <td>45-54</td>
                            <td>62</td>
                            <td>3.5%</td>
                        </tr>
                        <tr>
                            <td>55-64</td>
                            <td>54</td>
                            <td>3.0%</td>
                        </tr>
                        <tr>
                            <td>Over 65</td>
                            <td>31</td>
                            <td>1.7%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="gender" role="tabpanel" aria-labelledby="genderTab">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Gender</th>
                            <th>Users</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Male</td>
                            <td>1203</td>
                            <td>67.5%</td>
                        </tr>
                        <tr>
                            <td>Female</td>
                            <td>493</td>
                            <td>27.6%</td>
                        </tr>
                        <tr>
                            <td>Other</td>
                            <td>87</td>
                            <td>4.9%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="country" role="tabpanel" aria-labelledby="countryTag">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Country</th>
                            <th>Users</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>United States</td>
                            <td>473</td>
                            <td>26.5%</td>
                        </tr>
                        <tr>
                            <td>United Kingdom</td>
                            <td>383</td>
                            <td>21.5%</td>
                        </tr>
                        <tr>
                            <td>Germany</td>
                            <td>254</td>
                            <td>14.2%</td>
                        </tr>
                        <tr>
                            <td>Australia</td>
                            <td>171</td>
                            <td>9.6%</td>
                        </tr>
                        <tr>
                            <td>France</td>
                            <td>157</td>
                            <td>8.8%</td>
                        </tr>
                        <tr>
                            <td>Portugal</td>
                            <td>109</td>
                            <td>6.1%</td>
                        </tr>
                        <tr>
                            <td>Other</td>
                            <td>236</td>
                            <td>13.2%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<? include_once('../templates/footer.php'); ?>