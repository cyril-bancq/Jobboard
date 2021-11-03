<form action="" method="POST">
            <?= $form->input('name', 'Name :'); ?>
            <?= $form->input('activities', 'Activities :'); ?>
            <?= $form->input('address', 'Address :'); ?>
            <?= $form->input('postal_code', 'Postal Code :'); ?>
            <?= $form->input('city', 'City :'); ?>
            <?= $form->input('siret', 'SIRET :'); ?>
            <?= $form->input('email', 'Email :'); ?>
            <?= $form->input('number_employes', 'Number of employes :'); ?>
            <?= $form->input('website', 'Website :'); ?>
            <?= $form->input('phone', 'Phone :'); ?>
            <?= $form->input('password', 'Password :'); ?>
            <?= $form->textarea('contact_name', 'Contact :'); ?>
            <button class="btn btn-primary mt-2" onclick="return confirm('Do you really want to edit the user')">
            <?php if ($companies->getId() !== null) : ?>
                Edit   
            <?php else : ?>
                Create
            <?php endif ?></button>
</form>