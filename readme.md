Execitez les commandes suivantes

// uniquement si le depot n'est pas disponible en local

git clone https://github.com/abdiaschafy/cmcuapp.git

// Pour ouvrir dans le repertoire

cd cmcuapp

// Pour rendre disponible toutes les dependences presentes au niveau de fichier composer.json present a la racine

composer update

// Pour rendre disponible toutes les dependences presentes au niveau de fichier package.json present a la racine

npm install

// Pour faire miger tous les fichiers de migration au niveau de la base de donnees

php artisan migrate

// Pour seeder ou renseigner dea data fake dans la base donnees 

php artisan db:seed

###############################################################################

Voire le fichier de seed des utilisateurs 
