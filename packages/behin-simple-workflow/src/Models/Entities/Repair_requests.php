<?php 
namespace Behin\SimpleWorkflow\Models\Entities; 
use Behin\SimpleWorkflow\Controllers\Core\VariableController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
 class Repair_requests extends Model 
{ 
    public $table = 'wf_entity_repair_requests'; 
    protected $fillable = ['number', 'creation_date', 'customer_initial_description', 'mapa_expert_head', 'mapa_expert', 'other_parts', 'special_parts', 'power', 'see_the_problem', 'test_possibility', 'final_result', 'test_in_another_place', 'job_rank', 'washing', 'dispatched_expert_needed', 'customer_id', ]; 
}