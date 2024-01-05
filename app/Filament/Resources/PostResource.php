<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (?string $state, Get $get, Set $set) {
                            if (blank($get('slug'))) {
                                $set('slug', Str::slug($get('title')));
                            }
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(table: 'posts', column: 'slug', ignoreRecord: true),

                    Forms\Components\RichEditor::make('content'),

                    Select::make('categories')
                        ->multiple()
                        ->preload()
                        ->relationship('categories', 'name')
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('content'),
                            Forms\Components\Toggle::make('published')
                                ->default(true),
                        ]),

                    Forms\Components\TagsInput::make('tags')
                        ->separator(','),
                ])
                    ->columnSpan(2),
                Section::make([
                    Forms\Components\DateTimePicker::make('created_at')
                        ->disabled()
                        ->hiddenOn('create'),
                    Forms\Components\DateTimePicker::make('updated_at')
                        ->disabled()
                        ->hiddenOn('create'),
                    Forms\Components\Select::make('author_id')
                        ->relationship('author', 'name')
                        ->disabled()
                        ->default(auth()->id()),
                    Fieldset::make('Status')
                        ->schema([
                            Forms\Components\Toggle::make('published')
                                ->default(true),
                            Forms\Components\DateTimePicker::make('published_at')
                                ->default(now()),
                        ])->columns(1),

                    FileUpload::make('image')
                        ->previewable(),
                ])
                    ->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('d/m/y H:i')
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('published'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfolistSection::make([

                TextEntry::make('title')
                    ->size('lg')
                    ->weight('bold')
                    ->hiddenLabel(),

                ImageEntry::make('image')
                    ->view('post-image'),

                TextEntry::make('content')
                    ->hiddenLabel()
                    ->html()
                    ->alignJustify(),
            ])
                ->columnSpan(2),
            InfolistSection::make([

                Group::make([
                    TextEntry::make('created_at')
                        ->date(),
                    TextEntry::make('updated_at')
                        ->date(),

                    TextEntry::make('author.name')
                        ->color('primary'),

                    IconEntry::make('published')
                        ->boolean(),

                ])->columns(2),

                TextEntry::make('categories.name')
                    ->separator(',')
                    ->badge(),

                TextEntry::make('tags')
                    ->separator(',')
                    ->badge()
                    ->color('gray'),
            ])
                ->columnSpan(1),
        ])
            ->columns(3);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
