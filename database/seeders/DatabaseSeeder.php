<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        //$this->call(ChambresTableSeeder::class);
        //$this->call(ProduitsTableSeeder::class);
        //$this->call(PatientsTableSeeder::class);
        //$this->call(FichesTableSeeder::class);
       // $this->call(DevisTableSeeder::class);
        $this->call(AdaptationTraitementsTableSeeder::class);
        //$this->call(CleActivationsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(CompteRenduBlocOperatoiresTableSeeder::class);
        $this->call(ConsultationAnesthesistesTableSeeder::class);
        $this->call(ConsultationSuivisTableSeeder::class);
        $this->call(ConsultationsTableSeeder::class);
        // $this->call(DevisImagesTableSeeder::class);
        // $this->call(DevisdsTableSeeder::class);
        $this->call(DossiersTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(ExamensTableSeeder::class);
        $this->call(FactureChambresTableSeeder::class);
        $this->call(FactureClientsTableSeeder::class);
        $this->call(FactureConsultationsTableSeeder::class);
        $this->call(FactureDevisTableSeeder::class);
        $this->call(FactureProduitTableSeeder::class);
        $this->call(FacturesTableSeeder::class);
        $this->call(FicheConsommablesTableSeeder::class);
        $this->call(FicheInterventionsTableSeeder::class);
        $this->call(ImageriesTableSeeder::class);
        $this->call(InterventionsTableSeeder::class);
        $this->call(LicencesTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(ObservationMedicalesTableSeeder::class);
        $this->call(OrdonancesTableSeeder::class);
        $this->call(ParametresTableSeeder::class);
        $this->call(PremedicationsTableSeeder::class);
        $this->call(PrescriptionMedicalesTableSeeder::class);
        $this->call(PrescriptionsTableSeeder::class);
        $this->call(SoinsTableSeeder::class);
        $this->call(SoinsInfirmiersTableSeeder::class);
        $this->call(SqliteSequenceTableSeeder::class);
        $this->call(SurveillancePostAnesthesiquesTableSeeder::class);
        $this->call(SurveillanceRapprocheParametresTableSeeder::class);
        $this->call(SurveillanceScoresTableSeeder::class);
        $this->call(TraitementHospitalisationsTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(VisitePreanesthesiquesTableSeeder::class);
    }
}
