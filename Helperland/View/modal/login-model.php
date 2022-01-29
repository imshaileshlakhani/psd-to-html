<!-- modal start -->

    <!--login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <div class="form-title ">
                    <h4>Login to your account</h4>
                </div>
                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="" method="post">
                        <div class="col my-2">
                            <div class="form-group icon">
                                <input class="form-control" name="username" placeholder="Email" type="email"
                                    required /><i class=""></i>
                                <img alt="email" src="assets/images/user.png">
                            </div>
                        </div>
                        <div class="col my-2">
                            <div class="form-group icon">
                                <input class="form-control" name="password" placeholder="Password" type="text" required
                                    autofocus />
                                <img alt="Password" src="assets/images/lock.png">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember me
                            </label>
                        </div>
                        <div class="">
                            <button type="submit" name="signin" class="btn btn-block btn-round my-3 col-12">Login</button>
                        </div>
                        <div class="text-center col">
                            <p><a href="" data-bs-toggle="modal" data-bs-target="#forgotModal"
                                data-bs-dismiss="modal">Forgot
                                    password? </a></p>
                            <p>Don't have an account? <a href="#"> Create an account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- forgot modal -->
    <div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <div class="form-title">
                        <h4>Forgot password</h4>
                    </div>
                    <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="" method="post">
                            <div class="col my-2">
                                <div class="form-group icon">
                                    <input class="form-control" name="email" placeholder="Email" type="email"
                                        required /><i class=""></i>
                                    <img alt="email" src="assets/images/user.png">
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-block btn-round col-12 my-3">Send</button>
                            </div>
                            <div class="text-center col">
                                <p><a href="" data-bs-toggle="modal" data-bs-target="#loginModal"
                                    data-bs-dismiss="modal">Login now</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->