<?php
namespace App\Livewire\ClientsManagement;

use Livewire\Component;
use App\Models\Client;
use App\Models\BookingGroup;
use App\Models\Feedback;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use App\RepositoryInterface\FeedBackRepositoryInterface;

class CreateEditFeedback extends Component
{
    private $clientRepository, $experienceRepository, $feedbackRepository;

    public $query = ''; 
    public $clients = []; 
    public $selectedClient = null; 
    public $trips = []; 
    public $selectedTrip = null; 
    public $experience_types = [];

    public 
    	$rating = 1,
    	$comment, 
    	$service_quality = 1, 
    	$staff_behavior = 1, 
    	$cleanliness = 1, 
        $experience_type_id = null,
        $editFeedback = null,
    	$feed_back_id = null;

    public function __construct()
    {
        $this->clientRepository = App::make('ClientCrudRepository');
        $this->experienceRepository = App::make('ExperienceTypeCrudRepository');
        $this->feedbackRepository = app(FeedBackRepositoryInterface::class);
    }

    public function mount($feed_back_id = null)
    {
        if ($feed_back_id) {
            $this->feed_back_id = $feed_back_id;
            $this->editFeedback = $this->feedbackRepository->findById($feed_back_id);
            $this->rating = $this->editFeedback->rating;
            $this->comment = $this->editFeedback->comment;
            $this->service_quality = $this->editFeedback->service_quality;
            $this->staff_behavior = $this->editFeedback->staff_behavior;
            $this->cleanliness = $this->editFeedback->cleanliness;
            $this->experience_type_id = $this->editFeedback->experience_type_id;
            $this->selectClient($this->editFeedback->client_id);
        }
    }

    public function updateQuery()
    {
        if (strlen($this->query) >= 1) {
            $this->clients = Client::where('name', 'LIKE', "%{$this->query}%")
                ->orWhere('phone', 'LIKE', "%{$this->query}%")
                ->orWhere('mobile', 'LIKE', "%{$this->query}%")
                ->with('feed_backs') 
                ->get();
        } else {
            $this->clients = [];
        }
    }

    public function selectClient($clientId)
    {
        $this->selectedClient = $this->clientRepository->findById($clientId);
        $this->trips = BookingGroup::with([
                "booking",
                "client"
            ])
            ->where('client_id', $clientId)
            ->where('active', 1);
        if ($this->editFeedback)
            $this->trips = $this->trips->where('id', $this->editFeedback->booking_group_id);
        else
            $this->trips = $this->trips->whereDoesntHave('feed_backs');
        $this->trips = $this->trips->get();
        if ($this->editFeedback)
            $this->experience_types = $this->experienceRepository->getAll();
        else
            $this->experience_types = $this->experienceRepository->getActiveRecords();
        $this->query = ''; 
        $this->clients = [];
    }

    public function setComponentValues($name, $value)
    {
        $this->$name = $value;
    }

    public function render(): View
    {
        return view('admin.livewire.clients-management.create-edit-feedback');
    }
}
