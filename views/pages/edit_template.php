<div class="row g-7">
    <div class="col-lg-4 col-xl-4">
        <div class="card card-flush mt-6 mt-xl-9 p-8 bg-white">
            <img class="mw-100 mh-300px card-rounded-bottom" alt="" src="assets/media/illustrations/sigma-1/1.png">
            <p class="p-8">Click anywhere in the body of the email to start editing the document</p>
            <button type="button" onclick="goTo('send_mail')" class="btn btn-primary col-12">Finish Editing</button>
        </div>
    </div>

    <div class="col-lg-8 col-xl-8">
        <?php 
            include_once("templates/wysiwyg.php");
        ?>
    </div>
</div>
