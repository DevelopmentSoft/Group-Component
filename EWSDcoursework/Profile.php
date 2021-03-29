<?php include '../EWSDcoursework/Top.php' ?>

<body>
    <!-- our -->
    <div id="txtarea" class="our">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Student Profile</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 margin_bottom">
                    <div class="row">

                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="two-box">
                                <figure><img style="width:300px;height:250px;" src="../EWSDcoursework/Layout/mainpage/images/gradurate.jpg" alt="#" /></figure>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

                            <div class="txtarea">
                                <form>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="ID" aria-label="ID">
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Name" aria-label="name">
                                        </div>
                                        <br>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Password" aria-label="Password" required>
                                        </div>
                                        <div class="col">
                                            <input type="emial" class="form-control" placeholder="Email" aria-label="Email" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Gender" aria-label="Gender" required>
                                        </div>
                                        <div class="col">
                                            <input type="email" class="form-control" placeholder="Course" aria-label="Course" required>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control" placeholder="Birthdate" aria-label="Birth-date" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" style="float:right;">
                                        <button type="button" class="btn btn-primary">Save Change</button>
                                        <button style="margin-left:20px;" type="button" class="btn btn-success">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
   
    <!-- end our -->


</body>
<?php include '../EWSDcoursework/footer.php' ?>