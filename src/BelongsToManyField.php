<?php

namespace Trinityrank\BelongsToManyField;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ResourceRelationshipGuesser;
use Laravel\Nova\Http\Requests\NovaRequest;

class BelongsToManyField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'belongs-to-many-field';
    public $relation;
    public $relationModel;
    public $relationResourceName;
    public $options;
    public $selectedOptions;
    public $optionsLabel = 'title';


    public function __construct($name, $attribute, $relationResource, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute);

        $relationResource = $relationResource ?? ResourceRelationshipGuesser::guessResource($name);

        $this->relationModel = $relationResource::newModel();
        $this->relationResourceName = $relationResource::uriKey();

        $this->relation = $attribute;

        $this->fillUsing(function ($request, $model, $attribute) {
            if (is_subclass_of($model, 'Illuminate\Database\Eloquent\Model')) {
                $model::saved(function ($model) use ($attribute, $request) {
                    if ($request->input($attribute) !== null) {
                        $model->$attribute()->sync(explode(',',$request->input($attribute)));
                    } else {
                        $model->$attribute()->detach();
                    }
                });
                $request->except($attribute);
            }
        });
    }


    public function resolve($resource, $attribute = null)
    {
        $this->setOptions($resource);
    }

    public function optionsLabel($label)
    {
        $this->optionsLabel = $label;
    }

    public function setOptions($resource)
    {
        $this->options = $this->relationModel::all()
            ->mapWithKeys(
                function ($item) {
                    return [$item['id'] => $item[$this->optionsLabel]];
                }
            )
            ->toArray();

        $this->selectedOptions = $resource->{$this->relation}
            ->map(
                function ($item) {
                    return  [
                        'id' => $item['id'],
                        'value' => $item[$this->optionsLabel],
                    ];
                }
            )
            ->toArray();
    }


    public function jsonSerialize(): array
    {
        return with(app(NovaRequest::class), function ($request) {
            return array_merge([
                'uniqueKey' => sprintf('%s-%s-%s', $this->attribute, Str::slug($this->panel ?? 'default'),
                    $this->component()), 'attribute' => $this->attribute, 'component' => $this->component(),
                'indexName' => $this->name, 'name' => $this->name, 'nullable' => $this->nullable,
                'panel' => $this->panel, 'prefixComponent' => true, 'readonly' => $this->isReadonly($request),
                'required' => $this->isRequired($request), 'sortable' => $this->sortable,
                'sortableUriKey' => $this->sortableUriKey(), 'stacked' => $this->stacked,
                'textAlign' => $this->textAlign, 'validationKey' => $this->validationKey(),
                'value' => $this->value ?? $this->resolveDefaultValue($request), 'visible' => $this->visible,
                'wrapping' => $this->wrapping,
                'options' => $this->options,
                'selectedOptions' => $this->selectedOptions,
                'relationResourceName' => $this->relationResourceName
            ], $this->meta());
        });
    }
}
