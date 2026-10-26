public function toArray($request): array
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'author' => $this->user->name,
    ];
}
