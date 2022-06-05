<?php 
require 'Global' . DIRECTORY_SEPARATOR . 'header.php';

$user = new User();
$departments = $user->getDepartments();
$departments = arrayDepartmentToSelect($departments);

$trails = $user->getTrails();
$trails = arrayTrailToSelect($trails);

$levels = $user->getLevels();
$levels = arrayLevelToSelect($levels);

$error = [];
$succes = [];

if(!empty($_POST['Archiver'])){
    if(!empty($_FILES) && !empty($_POST['student']) && !empty($_POST['department']) && !empty($_POST['trail']) && !empty($_POST['level']) && !empty($_POST['date'])){
        
        $regist_num_student = $_POST['student'];
        $id_student = $user->getIdStudentByRegist_number($regist_num_student);
        $id_faculty = $_POST['faculty'];
        $id_department = $_POST['department'];
        $id_trail = $_POST['trail'];
        $id_level = $_POST['level'];
        $obtained_at = $_POST['date'];

        $file_name = $_FILES['file']['name'];
        $file_extention = strrchr($file_name, '.');
        $extentions = ['.pdf', '.PDF', '.Pdf'];
        $pdf_tmp_name = $_FILES['file']['tmp_name'];

        $trail = $user->getTrailById($id_trail);
        $trail_name = $trail['trail'];
        $level = $user->getLevelById($id_level);
        $level_name = $level['level'];
        $pdf_name = $regist_num_student . '_' . $level_name . '_' . $trail_name . '.pdf';
        $pdf_link = 'files/' . $pdf_name;


        if(is_int($id_student)){
            
            if(in_array($file_extention, $extentions) && $_FILES['file']['error'] == 0 && empty($error)){
        
                if(!file_exists($pdf_link)){

                    if(move_uploaded_file($pdf_tmp_name, $pdf_link)){
                        dump($pdf_name);
                        $releve = new Releve();
                        $releve->hydrate(['id_student'=>$id_student, 'id_faculty'=>$id_faculty, 'id_department'=>$id_department, 'id_trail'=>$id_trail, 'id_level'=>$id_level, 'pdf_name'=>$pdf_name, 'pdf_link'=>$pdf_link , 'obtained_at'=>$obtained_at]);
                        
                        if($user->addToArchive($releve)){
                            $succes['upload'] = "Relevé archivé avec succes";
                        }
                        else{
                            $error['upload'] = "Ooops!!! Le fichier n'a pas pu etre archivé";
                        }
                    }
                    else{
                        $error['upload'] = 'Le fichier n\'a pas pu etre uploadé. Reessayer...';
                    }
                }
                else{
                    $error['file'] = 'Le relevé de notes de cet etudiant a déjà été archivé<br>Consulter le fichier <a href="'. $pdf_link .'">ici</a>';
                }
            }
            else{
                $error['extention'] = 'Seul les fichiers pdf sont autorisés';
            }
        }
        else{
            $error['student'] = 'Cet etudiant n\'existe pas dans notre base de donnees';
        }

    }
    else{
        $error['empty'] = "Veuillez renseigner tous les champs svp";
    }
}

if(!empty($_POST['search']) && !empty($_POST['student'])){
    
    $regist_num_student = $_POST['student'];
    $student = $user->getStudentByRegist_number($regist_num_student);
    $releves = $user->getRelevesByStudentRegist_number($regist_num_student);
}

?>

    <div class="container">
        <div class="part1">
            <div class="frame1">
                <img src="Img/logoFS.jpg" alt="Logo de la faculte des sciences" id = "logoFS">
            </div>
        </div>
        
        <div class="part2">
            <div class="container-form">
                <div class="form">
                    <?php
                    if(!isset($_GET['archives'])){
                        echo '<h3 class="form-title">Formulaire d\'archivage</h3>';
                        $form = new Form('post', 'index.php', 'multipart/form-data');
                        if(!empty($error))
                            $form->errorsBox($error);
                        if(!empty($succes))
                            $form->sucessBox($succes);
    
                        $form->inputText('student', 'Matricule de l\'etudiant', 'Matricule', true, 'required');
                        $form->inputHidden('faculty', '1');
                        $form->select('department', $departments, 'Departement', true, 'required');
                        $form->select('trail', $trails, 'Filiere', true, 'required');
                        $form->select('level', $levels, 'Niveau', true, 'required');
                        $form->inputDate('date', 'Date d\'optention', true, 'required');
                        $form->inputFile('file', 'le fichier', 'Le releve de note en PDF', true, 'required');
                        $form->submitButton('Archiver');
                        echo $form->getForm();
                    }
                    else{
                        echo '<h3 class="form-title">Rechercher dans les archives</h3>';
                        $form = new Form('post', 'index.php?archives=1');
                        if(!empty($error))
                            $form->errorsBox($error);
                        if(!empty($succes))
                            $form->sucessBox($succes);
    
                        $filtre = [
                            '1' => 'Matricule',
                            '2' => 'Date',
                            '3' => 'Date Niveau',
                            '4' => 'Date Filiere'
                        ];

                        //$form->select('filtre', $filtre, 'Filtre', false, '', '1');
                        $form->inputSearch('student', 'Matricule de l\'etudiant', 'search', 'required');
                        echo $form->getForm();
                    }
                ?>

                </div>

            </div>
            <?php
                if(isset($releves)){
                    ?>
                    <div class="list-releves">
                        <?php
                            if(empty($releves)){
                                echo '<h3>Aucune archive pour ce matricule</h3>';
                            }
                            else{
                                echo '<h3>Etudiant: ' . $student['name'] . ' ' . $student['surname'] . '</h3>';
                                echo '<h3>Matricule: ' . $student['regist_number'] . '</h3>';
                                echo '<ul>';
                                foreach($releves as $releve){
                                    echo '<li>' . $releve['pdf_name'] . ' <a href="'.$releve['pdf_link'].'"> consulter</a></li>';
                                }
                                echo '</ul>';
                            }
                        ?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>

<?php require 'Global' . DIRECTORY_SEPARATOR . 'footer.php'; ?>