<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ScholarshipResource\Pages;
use App\Models\Scholarship;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ScholarshipResource extends Resource
{
    protected static ?string $model = Scholarship::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Scholarships';

    protected static ?string $modelLabel = 'Scholarship';

    protected static ?string $pluralModelLabel = 'Scholarships';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('target_level')
                    ->default('S1')
                    ->dehydrated(),

                Forms\Components\Hidden::make('intake_semester')
                    ->default('fleksibel')
                    ->dehydrated(),

                Forms\Components\Hidden::make('eligibility_status')
                    ->default('semua')
                    ->dehydrated(),

                Forms\Components\Hidden::make('funding_type')
                    ->default('full')
                    ->dehydrated(),

                Forms\Components\Hidden::make('min_gpa')
                    ->default(0)
                    ->dehydrated(),

                Forms\Components\Hidden::make('deadline')
                    ->default(now()->addMonth()->toDateString())
                    ->dehydrated(),

                Forms\Components\Section::make('Informasi Beasiswa')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Beasiswa')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('provider')
                            ->label('Penyelenggara')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('country')
                            ->label('Negara / Lokasi')
                            ->placeholder('Contoh: Indonesia')
                            ->maxLength(255),

                        Forms\Components\Select::make('scholarship_scope')
                            ->label('Cakupan Beasiswa')
                            ->options([
                                'domestic' => 'Dalam Negeri',
                                'abroad' => 'Luar Negeri',
                                'both' => 'Dalam & Luar Negeri',
                            ])
                            ->default('domestic')
                            ->required(),

                        Forms\Components\TextInput::make('funding_label')
                            ->label('Tipe Pendanaan')
                            ->placeholder('Contoh: Fully Funded, Bantuan UKT, Uang Saku')
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif Ditampilkan')
                            ->default(true),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Kriteria Penerima')
                    ->columns(2)
                    ->schema([
                        Forms\Components\MultiSelect::make('eligible_statuses')
                            ->label('Status Pendidikan yang Bisa Mendaftar')
                            ->options([
                                'active' => 'Pelajar/Mahasiswa Aktif',
                                'inactive_graduated' => 'Tidak Aktif/Sudah Lulus',
                                'gap_year' => 'Gap Year',
                                'general' => 'Umum',
                            ])
                            ->helperText('Pilih satu atau lebih kategori user yang boleh mendaftar.')
                            ->required(),

                        Forms\Components\MultiSelect::make('eligible_levels')
                            ->label('Jenjang yang Bisa Mendaftar')
                            ->options([
                                'SMP' => 'SMP',
                                'SMA' => 'SMA/SMK/MA',
                                'D3' => 'D3',
                                'D4' => 'D4',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                                'Profesi' => 'Profesi',
                            ])
                            ->helperText('Contoh: Glow & Lovely untuk SMA/Gap Year target S1; BSI untuk S1 semester tertentu.')
                            ->required(),

                        Forms\Components\MultiSelect::make('eligible_semesters')
                            ->label('Semester yang Bisa Mendaftar')
                            ->options([
                                'calon_mahasiswa' => 'Calon Mahasiswa Baru / Belum Dapat Kampus',
                                'semester_1' => 'Semester 1 / Sudah Diterima Kampus',
                                'semester_2' => 'Semester 2',
                                'semester_3' => 'Semester 3',
                                'semester_4' => 'Semester 4',
                                'semester_5' => 'Semester 5',
                                'semester_6' => 'Semester 6',
                                'semester_7' => 'Semester 7',
                                'semester_8' => 'Semester 8',
                                'semester_9_plus' => 'Semester 9 atau lebih',
                            ])
                            ->helperText('Kosongkan jika beasiswa tidak membatasi semester.'),

                        Forms\Components\Select::make('allowed_institution_type')
                            ->label('Status Sekolah/Kampus yang Boleh')
                            ->options([
                                'all' => 'Semua',
                                'PTN' => 'PTN',
                                'PTS' => 'PTS',
                                'school' => 'Sekolah / SMA / SMK / MA',
                                'not_applicable' => 'Tidak Berlaku',
                            ])
                            ->default('all')
                            ->required(),

                        Forms\Components\TextInput::make('minimum_gpa')
                            ->label('Minimal IPK')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(4)
                            ->step(0.01)
                            ->placeholder('Kosongkan jika tidak ada syarat IPK'),

                        Forms\Components\MultiSelect::make('allowed_genders')
                            ->label('Gender yang Bisa Mendaftar')
                            ->options([
                                'male' => 'Laki-Laki',
                                'female' => 'Perempuan',
                            ])
                            ->helperText('Kosongkan jika terbuka untuk semua gender.'),

                        Forms\Components\Toggle::make('allow_active_scholarship_holder')
                            ->label('Boleh Sedang Menerima Beasiswa Lain')
                            ->default(false),

                        Forms\Components\Toggle::make('requires_low_income')
                            ->label('Khusus Keluarga Kurang Mampu')
                            ->default(false),

                        Forms\Components\Textarea::make('eligible_institutions')
                            ->label('Kampus/Sekolah yang Bisa Mendaftar')
                            ->placeholder('Contoh: Semua PTN/PTS di Indonesia, hanya kampus mitra, atau nama kampus tertentu.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Jadwal Pendaftaran')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('registration_start')
                            ->label('Mulai Pendaftaran')
                            ->required(),

                        Forms\Components\DatePicker::make('registration_deadline')
                            ->label('Deadline Pendaftaran')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Benefit, Persyaratan, dan Dokumen')
                    ->schema([
                        Forms\Components\Textarea::make('benefit')
                            ->label('Benefit')
                            ->placeholder("Contoh:\n- Bantuan UKT\n- Uang saku\n- Program pembinaan")
                            ->rows(5)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('requirements')
                            ->label('Persyaratan')
                            ->placeholder("Contoh:\n- WNI\n- Mahasiswa S1 semester 3\n- IPK minimal 3.00\n- Tidak sedang menerima beasiswa lain")
                            ->rows(7)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('documents')
                            ->label('Dokumen yang Dibutuhkan')
                            ->placeholder("Contoh:\n- KTP\n- KTM\n- Transkrip nilai\n- Surat rekomendasi")
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Link')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('booklet_link')
                            ->label('Link Booklet')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('apply_link')
                            ->label('Link Daftar')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('official_link')
                            ->label('Link Resmi / Website')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Beasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('provider')
                    ->label('Penyelenggara')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('eligible_levels')
                    ->label('Jenjang')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        if (is_array($state)) {
                            return implode(', ', $state);
                        }

                        return $state ?? '-';
                    }),

                Tables\Columns\TextColumn::make('allowed_institution_type')
                    ->label('Kampus')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'PTN' => 'PTN',
                        'PTS' => 'PTS',
                        'all' => 'Semua',
                        'school' => 'Sekolah',
                        'not_applicable' => 'Tidak Berlaku',
                        default => '-',
                    }),

                Tables\Columns\TextColumn::make('minimum_gpa')
                    ->label('Min IPK')
                    ->formatStateUsing(fn ($state): string => $state ? (string) $state : '-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('registration_start')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('registration_deadline')
                    ->label('Deadline')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('allowed_institution_type')
                    ->label('Status Kampus')
                    ->options([
                        'all' => 'Semua',
                        'PTN' => 'PTN',
                        'PTS' => 'PTS',
                        'school' => 'Sekolah',
                        'not_applicable' => 'Tidak Berlaku',
                    ]),

                Tables\Filters\SelectFilter::make('scholarship_scope')
                    ->label('Cakupan')
                    ->options([
                        'domestic' => 'Dalam Negeri',
                        'abroad' => 'Luar Negeri',
                        'both' => 'Dalam & Luar Negeri',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('registration_deadline', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScholarships::route('/'),
            'create' => Pages\CreateScholarship::route('/create'),
            'edit' => Pages\EditScholarship::route('/{record}/edit'),
        ];
    }
}