<?
    require_once 'classes/UserForm.php'; // class user
    require_once 'classes/ErrorCollector.php'; // class error
    use Classes\UserForm;
    use Classes\ErrorCollector;

    $user = new UserForm();
    $error = new ErrorCollector();
    $i = 1;
    $success = false;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Форма пользователей</title>
    </head>
    <body>
        <?  
            // можна робити відразу в класі, але я залишу його тут для кращого розумінняи 
            $userDefault = [
                [
                    'id' => 1,
                    'name' => 'Andrey Bogdanov',
                    'mail' => 'andry@gmail.com',
                    'password' => password_hash("andrypassword", PASSWORD_DEFAULT),
                ],
                [
                    'id' => 2,
                    'name' => 'Slava Mozgov',
                    'mail' => 'slava@gmail.com',
                    'password' => password_hash("slavapassword", PASSWORD_DEFAULT),
                ]
            ];

            foreach($userDefault as $userList) {
                $i++;
                $user->addUser($userList);
            }

            if(!empty($_POST['user'])) {
                if (!str_contains($_POST['user']['mail'], '@')) {
                    $error->addError('У вашому рядку немає символу "@", будь ласка, додайте його і спробуйте знову');
                }

                if($user->checkUserMail($_POST['user']['mail'])) {
                    $error->addError('Користувач із таким E-mail вже існує');
                }

                if($_POST['user']['password'] !== $_POST['user']['conf_password']) {
                    $error->addError('Паролі не співпадають!');
                }

                if(!$error->getFormattedErrors()) {
                    $addUser = [
                        'id' => $i,
                        'name' => $_POST['user']['name'].' '.$_POST['user']['last_name'],
                        'mail' => $_POST['user']['mail'],
                        'password' => password_hash($_POST['user']['password'], PASSWORD_DEFAULT),
                    ];

                    $success = true;

                    $user->addUser($addUser);
                }
        }
        ?>

        <section class="vh-100">
            <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body p-5">
                                    <?
                                        if($error->getFormattedErrors()):
                                            foreach($error->getFormattedErrors() as $viewError):
                                    ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <?= $viewError;?>
                                                </div>
                                    <?
                                            endforeach;
                                        endif;
                                    ?>
                                    <?if($success == false):?>
                                        <h2 class="text-uppercase text-center mb-5">Форма регістрації</h2>
                                        <form method="POST">
                                            <div class="form-outline mb-4">
                                                <input type="text" class="form-control form-control-lg" name="name"/>
                                                <label class="form-label" for="form3Example1cg">Ваше ім’я</label>
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="text" class="form-control form-control-lg" name="last_name"/>
                                                <label class="form-label" for="form3Example1cg">Ваша прізвище</label>
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="email" class="form-control form-control-lg" name="mail"/>
                                                <label class="form-label" for="form3Example3cg">Ваш email</label>
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="password" class="form-control form-control-lg" name="password"/>
                                                <label class="form-label" for="form3Example4cg">Пароль</label>
                                            </div>
                                            <div class="form-outline mb-4">
                                                <input type="password" class="form-control form-control-lg" name="conf_password"/>
                                                <label class="form-label" for="form3Example4cdg">Повторення пароля</label>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" id="task" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Відправити</button>
                                            </div>
                                        </form>
                                    <?else:?>
                                        <div class="alert alert-success" role="alert">  
                                            Ви успішно зареєстровані!
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="table-responsive">
                <h2 class="text-uppercase text-center mb-5">Список користувачів</h2>
                <table class="table">
                    <?
                        $userList = $user->getUserList();
                    ?>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Им'я</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Пароль</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach($userList as $userInfo):?>
                            <tr>
                                <th scope="row"><?= $userInfo['id']?></th>
                                <td><?= $userInfo['name']?></td>
                                <td><?= $userInfo['mail']?></td>
                                <td><?= $userInfo['password']?></td>
                            </tr>
                        <?endforeach?>
                    </tbody>
                </table>
            </div>
        </section>
    </body>
    <footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="script.js"></script>
    </footer>
</html>

<?
function pr($a)
{
    echo '<pre>';
    print_r($a);
    echo '</pre>';
}
?>