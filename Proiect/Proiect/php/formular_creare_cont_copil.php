<form name="register" method="post" action="php/creare_cont_copil.php"> 			
                
                <strong>Nume complet:</strong><br>
                <?php
					
                    if (!isset($_COOKIE['empty_field1']) and !isset($_COOKIE['caractere_interzise_in_nume'])){
                        echo '<input type="text" name="name" placeholder=" name"/><br>';
                    }else{
                        echo '<input type="text" name="name" placeholder=" name" id="wrong" /><br>';
                    }
                
                echo '<strong>Nume cont:</strong><br>';
                
                    if (!isset($_COOKIE['empty_field2']) and !isset($_COOKIE['username_already_exist']) and !isset($_COOKIE['caractere_interzise_in_username']) and !isset($_COOKIE['caractere_putine_in_user'])){
                        echo '<input type="text" name="username" placeholder=" username"/><br>';
                    }else{
                        echo '<input type="text" name="username" placeholder=" username" id="wrong"/><br>';
                    }
                

                echo '<strong>Parola:</strong><br>';            
                
                    if (!isset($_COOKIE['empty_field3']) and !isset($_COOKIE['pass_not_matching']) and !isset($_COOKIE['caractere_interzise_in_pass1']) and !isset($_COOKIE['caractere_putine_in_pass'])){
                        echo '<input type="password" name="pass" placeholder=" introduceti parola"/><br>';
                    }else{
						echo '<input type="password" name="pass" placeholder=" introduceti parola" id="wrong"/><br>';
                    }
                
                
                echo '<strong>Reintroduceti parola:</strong><br>';
                
                    if (!isset($_COOKIE['empty_field4']) and !isset($_COOKIE['pass_not_matching']) and !isset($_COOKIE['caractere_interzise_in_pass2'])){
                        echo '<input type="password" placeholder=" reintroduceti parola" name="pass2"/><br>';
                    }else{
                        echo '<input type="password" placeholder=" reintroduceti parola" name="pass2" id="wrong"/><br>';
                    }
                
                
                
                    if (isset($_COOKIE['empty_field1']) or isset($_COOKIE['empty_field2']) or isset($_COOKIE['empty_field3']) or isset($_COOKIE['empty_field4']) or (isset($_COOKIE['pass_not_matching']) and $_COOKIE['pass_not_matching']==1)){
                        echo '<p style="color: red"> * Toate campurile sunt obligatorii<p><br>';
                    }
					if(isset($_COOKIE['pass_not_matching'])){
						if($_COOKIE['pass_not_matching']==2){
							echo '<p style="color: red"> ** Parolele nu corespund<p><br>';
						}
                    }
					if(isset($_COOKIE['username_already_exist'])){
						echo '<p style="color: red"> *** Acest cont este inregistrat deja<p><br>';
					}
					if(isset($_COOKIE['caractere_interzise_in_username']) or isset($_COOKIE['caractere_interzise_in_pass1']) or isset($_COOKIE['caractere_interzise_in_pass2']) or isset($_COOKIE['caractere_interzise_in_nume'])){
						echo '<p style="color: red"> **** Ai folosit caractere interzise! <p><br>'; 
						echo '<p style="color: red"> Caractere valide: <p>';
						echo '<p style="color: red; font-size: 70%;"> Nume -> Litere mari si mici din alfabetul englez, spatiu si minus <p>';
						echo '<p style="color: red; font-size: 70%;"> Username -> Litere mari si mici din alfabetul englez si/sau cifre <p>';
						echo '<p style="color: red; font-size: 70%;"> Parola -> Litere mari si mici din alfabetul englez si/sau cifre <p>';
					}
					if(isset($_COOKIE['caractere_putine_in_user']) or isset($_COOKIE['caractere_putine_in_pass'])){
						echo '<p style="color: red"> **** Numar mic de caractere <p><br>';
						echo '<p style="color: red"> Numarul de caractere trebuie sa fie minim: <p>';
						echo '<p style="color: red; font-size: 70%;"> 4 - pentru nume <p>';
						echo '<p style="color: red; font-size: 70%;"> 6 - pentru parola <p>';						
					}
                ?>
                
                <input type="submit" class="register" value="sign in"  />

			</form>
