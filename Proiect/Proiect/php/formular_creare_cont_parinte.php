<form name="register" method="post" action="php/creare_cont_parinte.php"> 			
                
                <strong>Nume complet:</strong><br>
                <?php
					
                    if (!isset($_COOKIE['empty_field1'])){
                        echo '<input type="text" name="name" placeholder=" name"/><br>';
                    }else{
                        echo '<input type="text" name="name" placeholder=" name" id="wrong" /><br>';
                    }
                
                echo '<strong>Email:</strong><br>';
                
                    if (!isset($_COOKIE['empty_field2']) and !isset($_COOKIE['email_already_exist']) and !isset($_COOKIE['invalid_email_address']) and !isset($_COOKIE['email_not_matching'])){
                        echo '<input type="text" name="email" placeholder=" email"/><br>';
                    }else{
                        echo '<input type="text" name="email" placeholder=" email" id="wrong"/><br>';
                    }
				
				echo '<strong>Reintroduceti email-ul:</strong><br>';
                
                    if (!isset($_COOKIE['empty_field3']) and !isset($_COOKIE['email_already_exist']) and !isset($_COOKIE['email_not_matching'])){
                        echo '<input type="text" name="email2" placeholder=" reintroduceti email-ul"/><br>';
                    }else{
                        echo '<input type="text" name="email2" placeholder=" reintroduceti email-ul" id="wrong"/><br>';
                    }
                

                echo '<strong>Parola:</strong><br>';            
                
                    if (!isset($_COOKIE['empty_field4']) and !isset($_COOKIE['pass_not_matching'])){
                        echo '<input type="password" name="pass" placeholder=" introduceti parola"/><br>';
                    }else{
						echo '<input type="password" name="pass" placeholder=" introduceti parola" id="wrong"/><br>';
                    }
                
                
                echo '<strong>Reintroduceti parola:</strong><br>';
                
                    if (!isset($_COOKIE['empty_field5']) and !isset($_COOKIE['pass_not_matching'])){
                        echo '<input type="password" placeholder=" reintroduceti parola" name="pass2"/><br>';
                    }else{
                        echo '<input type="password" placeholder=" reintroduceti parola" name="pass2" id="wrong"/><br>';
                    }
                
                
                
                    if (isset($_COOKIE['empty_field1']) or isset($_COOKIE['empty_field2']) or isset($_COOKIE['empty_field3']) or isset($_COOKIE['empty_field4']) or isset($_COOKIE['empty_field5']) or (isset($_COOKIE['pass_not_matching']) and $_COOKIE['pass_not_matching']==1)){
                        echo '<p style="color: red"> * Toate campurile sunt obligatorii<p><br>';
                    }
					if(isset($_COOKIE['pass_not_matching'])){
						if($_COOKIE['pass_not_matching']==2){
							echo '<p style="color: red"> ** Parolele nu corespund<p><br>';
						}
                    }
					if(isset($_COOKIE['email_already_exist'])){
						echo '<p style="color: red"> *** Exista deja un cont creat pe aceasta adresa de email<p><br>';
					}
					if(isset($_COOKIE['invalid_email_address'])){
						echo '<p style="color: red"> **** Adresa de mail nu este valida<p><br>';
					}
					if(isset($_COOKIE['email_not_matching'])){
						echo '<p style="color: red"> ***** Adresele de mail nu corespund<p><br>';
					}
                ?>
                
                <input type="submit" class="register" value="sign in"  />

			</form>