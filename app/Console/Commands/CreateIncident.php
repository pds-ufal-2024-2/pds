<?php

namespace App\Console\Commands;

use App\Models\Incident;
use App\Models\UpIncident;
use Illuminate\Console\Command;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\form;

class CreateIncident extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-incident';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new incident record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new incident record...');

        $confirm = confirm(
            label: 'Do you like to start creating a new incident with mock data?', 
            default: true
        );

        $incident = new Incident();
        if ($confirm) {
            $incident = Incident::factory()->make();
        }

        $response = form()
            ->text('Code', default: $incident->code ?? '', name: 'code')
            ->text('Image URL', default: $incident->image ?? '', name: 'image')
            ->text('Incident', default: $incident->incident ?? '', name: 'incident')
            ->text('Description', default: $incident->description ?? '', name: 'description')
            ->text('Category', default: $incident->category ?? '', name: 'category')
            ->text('Latitude', default: $incident->latitude ?? '', name: 'latitude')
            ->text('Longitude', default: $incident->longitude ?? '', name: 'longitude')
            ->text('Suggestions', default: $incident->suggestions ?? '', name: 'suggestions')
            ->select('Status', options: ['open' => 'Open', 'closed' => 'Closed'], default: 'open', name: 'status')
            ->text('Entity', default: $incident->entity ?? '', name: 'entity')
            ->text('Bairro', default: $incident->bairro ?? '', name: 'bairro')
            ->confirm('Public Visibility', default: true, name: 'public_visibility')
            ->text('Number of Up Votes', default: 0, name: 'counter', validate: 'integer|min:0')
            ->select('Priority', options: ['low' => 'Low', 'normal' => 'Normal', 'high' => 'High'], default: 'normal', name: 'priority')
            ->submit();

        $incident->fill($response);
        $incident->save();

        UpIncident::factory()->count($response['counter'])->for($incident)->create();

        $this->info('Incident created successfully!');
    }
}
