<main class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm border-0 rounded-3 mb-3">
                    <div class="card-header bg-white border-0 text-center py-3">
                        <h4 class="mb-0 fw-semibold">ECOMMERCE</h4>
                    </div>

                    <div class="card-body px-4 py-4">
                        <form method="POST" action="<?php echo URL; ?>/login/proses">
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end">
                                    Email Address
                                </label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control"
                                        name="email" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end">
                                    Password
                                </label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control"
                                        name="password" required>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4 d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Login
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <?php if (isset($_SESSION['login']) && $_SESSION['login'] == false) { ?>
                    <div class="alert alert-danger">
                        Login tidak di temukan!
                    </div>
                <?php } ?>

            </div>
        </div>

    </div>
</main>