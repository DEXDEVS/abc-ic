<?php 
    $userID = Yii::$app->user->id;
    $user = Yii::$app->db->createCommand("SELECT user_photo FROM user WHERE id = $userID")->queryAll();
    // Student Photo...
    // var_dump($user);
    $userPhoto = $user[0]['user_photo'];
    if(empty($userPhoto)){
        $userPhoto = 'backend/web/images/default.png';
    }
?>
<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $userPhoto ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>
                <?php 
                //var_dump($userPhoto);
                    $cnic = Yii::$app->user->identity->username;
                    if (Yii::$app->user->identity->user_type == 'Student') {
                        $userName = Yii::$app->db->createCommand("SELECT std_name FROM std_personal_info WHERE std_b_form = '$cnic'")->queryAll();
                        echo $userName[0]['std_name'];
                    }
                    else if(Yii::$app->user->identity->user_type == 'Parent') {
                        $userName = Yii::$app->db->createCommand("SELECT guardian_name FROM std_guardian_info WHERE guardian_cnic = '$cnic'")->queryAll();
                        echo $userName[0]['guardian_name'];
                    }
                    else if(Yii::$app->user->identity->user_type == 'Teacher') {
                        $userName = Yii::$app->db->createCommand("SELECT emp_name FROM emp_info WHERE emp_cnic = '$cnic'")->queryAll();
                        echo $userName[0]['emp_name'];
                    }
                    else{
                        echo Yii::$app->user->identity->username;
                    }
                ?>
                    <!--  -->
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
<?php  if (Yii::$app->user->identity->user_type == 'Teacher') { ?>
        <?=  dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Portfolio', 'icon' => 'user', 'url' => './employee-portfolio'],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                     [
                        'label' => 'Class Time Table',
                        'icon' => 'calendar',
                        'url' => './home',
                    ],
                    [
                        'label' => 'Class',
                        'icon' => 'copy',
                        'items' =>[
                             ['label' => 'Activity', 'icon' => 'caret-right', 'url' => ["./list-of-classes"],],
                            ['label' => 'View Classes', 'icon' => 'caret-right', 'url' => ["./view-classes"],],   
                        ]
                    ],
                    [
                        'label' => 'Students',
                        'icon' => 'users',
                        'items' => [
                            ['label' => 'Profile', 'icon' => 'caret-right', 'url' => ["./students-view"],],
                        ]
                    ],
                    [
                        'label' => 'Communication',
                        'icon' => 'envelope-o',
                        'items' => [
                            ['label' => 'SMS', 'icon' => 'caret-right', 'url' => ["./home"],],
                             ['label' => 'Email', 'icon' => 'caret-right', 'url' => ["./home"],],
                        ]
                    ],

                   [
                        'label' => 'Apply Leave',
                        'icon' => '',
                        'url' => './emp-leave',
                    ],
                    
                    // ------------------------------------------------
                    // Student Attendance end...
                    // ------------------------------------------------
                ],
            ]
        );

        } // closing of Teacher 
        if (Yii::$app->user->identity->user_type == 'Student') {
             ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Porfile', 'icon' => 'user', 'url' => './employee-portfolio'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        );

        } // closing of Students 
        if(Yii::$app->user->identity->user_type == 'Parent') { ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header center']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => './home'],
                    ['label' => 'Portfolio', 'icon' => 'user', 'url' => './employee-portfolio'],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        );

        } // closing of Parent 
        ?>


    </section>

</aside>
