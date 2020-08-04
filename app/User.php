<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function taskTrackings()
    {
        return $this->hasMany(TaskTracking::class, 'user_id');
    }

    public function folders()
    {
        return $this->hasMany(Folder::class, 'user_id');
    }

    public function topLevelFolders()
    {
        return $this->hasMany(Folder::class, 'user_id')->where('topLevel', '=', true);
    }

    public function subTaskTrackings()
    {
        return $this->hasMany(SubTaskTracking::class, 'user_id');
    }

    public function searchHistory()
    {
        return $this->hasMany(SearchHistory::class, 'user_id');
    }

    public function jotAuditCount()
    {
        if ($this->isAdmin) {
            return JotAudit::query()->where('read', '=', false)->where('is_admin', '=', 0)->count();
        } else {

            $userId = $this->id;

//            return DB::table('jot_audits')
//                ->select(
//                    DB::raw(
//                        'COUNT(jot_audits.id)'
//                    )
//                )->leftJoin(
//                    'tab_medicos_as_areas_de_atuacao',
//                    'tab_medicos_as_areas_de_atuacao.rel_area_atuacao_id',
//                    '=',
//                    'tab_areas_atuacoes.esp_id'
//                )->whereNull('deleted_at')
//                ->groupBy('tab_areas_atuacoes.esp_id'));

            $query = JotAudit::query()
                ->join('jots', function ($q) {
                    $q->on('jots.id', '=', 'jot_audits.jot_id')
                        ->where('jots.user_id', '=', $this->id);
                        })
                ->where('jot_audits.read', '=', 0)
                ->where('jot_audits.is_admin', '=', 1)
                ->count();

            return $query;
        }
    }


}
