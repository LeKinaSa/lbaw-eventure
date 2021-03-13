    <footer class="mt-auto bg-light">
        <div class="container p-3">
            <div class="row">
                <div class="col-md mb-2">
                    <span>© Copyright 2021 Eventure</span>
                </div>
                <div class="col-md mb-2">
                    <h5 class="text-uppercase">Help</h5>
                    <ul class="list-unstyled">
                        <li><a class="text-primary" href="about.php">About</a></li>
                        <li><a class="text-primary" href="contacts.php">Contacts</a></li>
                        <li><a class="text-primary" href="faq.php">FAQ</a></li>
                    </ul>
                </div>
                <? if (isset($role) && $role === 'admin') { ?>
                    <div class="col-md">
                        <h5 class="text-uppercase">Administration</h5>
                        <ul class="list-unstyled">
                            <li><a class="text-primary" href="user_management.php">User management</a></li>
                            <li><a class="text-primary" href="user_metrics.php">User metrics</a></li>
                            <li><a class="text-primary" href="event_metrics.php">Event metrics</a></li>
                        </ul>
                    </div>
                <? } ?>
            </div>
        </div>
    </footer>
    </body>
</html>