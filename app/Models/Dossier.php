<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dossier
 *
 * @property int $id
 * @property int $patient_id
 * @property string $sexe
 * @property string|null $personne_confiance
 * @property int|null $tel_personne_confiance
 * @property int|null $portable_1
 * @property int|null $portable_2
 * @property string|null $personne_contact
 * @property int|null $tel_personne_contact
 * @property string|null $profession
 * @property string|null $email
 * @property string|null $fax
 * @property string|null $adresse
 * @property string|null $lieu_naissance
 * @property string|null $date_naissance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patients
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereLieuNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePersonneConfiance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePersonneContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePortable1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePortable2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereTelPersonneConfiance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereTelPersonneContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dossier extends Model
{
    protected $fillable = [
        'patient_id',
        'sexe',
        'personne_confiaance',
        'tel_personne_confiance',
        'portables_1',
        'portable_2',
        'personne_contact',
        'tel_personne_contact',
        'profession',
        'email',
        'fax',
        'adresse',
        'lieu_naissance',
        'date_naissance'
    ];

    public function patients()
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
}
