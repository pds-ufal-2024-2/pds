<?php

namespace App\Jobs;

use App\LLM\Contracts\ISelectCategory;
use App\LLM\Contracts\IShortText;
use App\LLM\Contracts\ISuggestAction;
use App\LLM\ModelFactory;
use App\LLM\Models\Llava;
use App\Models\Incident;
use App\Models\IncidentHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\UploadedFile;

class ProcessUploadedImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Incident $incident,
        public string $photoPath,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get file content and convert to base64
        $data = file_get_contents($this->photoPath);
        $base64Image = base64_encode($data);

        // Retrieve the image description
        $imageModel = ModelFactory::imageModel();
        if ($imageModel instanceof Llava) {
            $imageModel = $imageModel->withTranslate(target: 'pt'); // Translate to Portuguese if needed
        }
        $this->incident->description = $imageModel->imageDescription($base64Image);
        $this->incident->save();

        $incidentHistory = new IncidentHistory();
        $incidentHistory->incident_id = $this->incident->id;
        $incidentHistory->message = "Descrição da imagem atualizada automaticamente: {$this->incident->description}";
        $incidentHistory->save();

        // Select the category
        $questionModel = ModelFactory::questionModel();
        $this->incident->category = 'Outra';
        if ($questionModel instanceof ISelectCategory) {
            $this->incident->category = $questionModel->selectCategory($this->incident->description);
        }
        $this->incident->save();

        $incidentHistory = new IncidentHistory();
        $incidentHistory->incident_id = $this->incident->id;
        $incidentHistory->message = "Categoria selecionada automaticamente: {$this->incident->category}";
        $incidentHistory->save();

        // Short text summary
        if ($questionModel instanceof IShortText) {
            $this->incident->incident = $questionModel->resumeText($this->incident->description);
        }

        $this->incident->save();

        $incidentHistory = new IncidentHistory();
        $incidentHistory->incident_id = $this->incident->id;
        $incidentHistory->message = "Resumo do incidente atualizado automaticamente: {$this->incident->incident}";
        $incidentHistory->save();

        // Suggest action
        if ($questionModel instanceof ISuggestAction) {
            $this->incident->suggestions = $questionModel->suggestAction($this->incident->description);
            $this->incident->save();
        }

        $incidentHistory = new IncidentHistory();
        $incidentHistory->incident_id = $this->incident->id;
        $incidentHistory->message = "Ação sugerida atualizada automaticamente: {$this->incident->suggestions}";
        $incidentHistory->save();
    }
}
