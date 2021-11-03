<form action="" method="POST">
            <?= $form->input('name', 'Name :'); ?>
            <?= $form->input('first_name', 'First Name :'); ?>
            <?= $form->input('phone', 'Phone number :'); ?>
            <?= $form->input('address', 'Address :'); ?>
            <?= $form->input('postal_code', 'Postal Code :'); ?>
            <?= $form->input('city', 'City :'); ?>
            <?= $form->input('email', 'Email :'); ?>
            <?= $form->input('birthdate', 'Birthdate :'); ?>
            <?= $form->input('cv', 'CV :'); ?>
            <?= $form->input('website', 'Website :'); ?>
            <?= $form->input('password', 'Password :'); ?>
            <?= $form->textarea('description', 'Description :'); ?>
            <button class="btn btn-primary mt-2" onclick="return confirm('Do you really want to edit the user')">
            <?php if ($users->getId() !== null) : ?>
                Edit   
            <?php else : ?>
                Create
            <?php endif ?></button>
</form>