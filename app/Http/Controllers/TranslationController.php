<?php namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TranslationController extends Controller
{
    
        /**
     * @OA\Post(
     *     path="/api/v1/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="key", type="string", example="welcome_message"),
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="value", type="string", example="Welcome to our website")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Translation created successfully")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|max:10',
            'key' => 'required|string',
            'value' => 'required|string',
            'tags' => 'nullable|array'
        ]);

        $translation = Translation::create($request->all());
        return response()->json($translation, 201);
    }


     /**
     * @OA\Get(
     *     path="/api/v1/translations",
     *     summary="Get all translations",
     *     tags={"Translations"},
     *     @OA\Response(response=200, description="List of translations")
     * )
     */
    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->has('locale')) {
            $query->where('locale', $request->locale);
        }
        if ($request->has('key')) {
            $query->where('key', 'like', "%{$request->key}%");
        }
        if ($request->has('tags')) {
            $query->whereJsonContains('tags', $request->tags);
        }

        return response()->json($query->paginate(50));
    }

    /**
     * @OA\Get(
     *     path="/api/translations/export",
     *     summary="Export all translations as JSON efficiently",
     *     tags={"Translations"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully exported translations",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "en": {
     *                     "welcome_message": "Welcome to our website",
     *                     "goodbye_message": "Goodbye and see you soon"
     *                 },
     *                 "fr": {
     *                     "welcome_message": "Bienvenue sur notre site",
     *                     "goodbye_message": "Au revoir et à bientôt"
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function export()
    {
        $translations = DB::table('translations')->select('locale', 'key', 'value')->get();
        
        // Using collection grouping instead of looping manually
        $groupedTranslations = $translations->groupBy('locale')->map(function ($items) {
            return $items->pluck('value', 'key');
        });

        return response()->json(['translations'=>$groupedTranslations], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
