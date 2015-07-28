<?php

namespace DirectDigital\Http\Controllers;

use DirectDigital\Services\BaseAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem as File;

class StatController extends Controller
{
    /**
     * Main I/O abstraction
     *
     * @var File
     */
    protected $file;

    /**
     * Get all the calculations for our analysis
     *
     * @var BaseAnalyzer
     */
    protected $analyzer;

    /**
     * Raw File Parser
     *
     * @var Parser
     */
    protected $parser;

    /**
     * @param File $file
     * @param BaseAnalyzer $analyzer
     */
    public function __construct(File $file,BaseAnalyzer $analyzer)
    {
        $this->file = $file;
        $this->analyzer = $analyzer;
    }

    /**
     *  Landing View
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $files = $this->file->files(storage_path('app'));
        $file_paths = [];

        foreach ($files as $file) {
            if (str_contains($file, 'ad-stats')) {
                $file_paths['ad_stats'] = $file;
            }
            if (str_contains($file, 'leads')) {
                $file_paths['leads'] = $file;
            }
            if (str_contains($file, 'orders')) {
                $file_paths['orders'] = $file;
            }
        }

        //quick error check
        if (count($file_paths) !== 3) {
            return view('stats.error')->with('file_missing_err', 'We did not have the proper files staged');
        }
        return view('stats.index', ['file_paths' => $file_paths]);
    }

    public function store(Request $request)
    {
        $ad_file = $request->input('ad_stats');
        $leads_file = $request->input('leads');
        $orders_file = $request->input('orders');


        if (isset($ad_file)) {
            if(!$this->analyzer->importFile($ad_file,'ads',['id','date','views'])){
                return view('stats.error')->with('loading_err', 'There was an issue loading the file. Try again');
            }
            unset($ad_file);
        }


        if (isset($leads_file)) {
            if(!$this->analyzer->importFile($leads_file, 'leads',['id','birthDate','adId','state','createdAt'])){
                return view('stats.error')->with('loading_err', 'There was an issue loading the file. Try again');
            }
            unset($leads_file);
        }

        if (isset($orders_file)) {
            if(!$this->analyzer->importFile($orders_file, 'orders',['id','leadId','unitPrice','quantity','shippingCost']))
            {
                return view('stats.error')->with('loading_err', 'There was an issue loading the file. Try again');
            }
            unset($orders_file);
        }


       return view('stats.show');

    }

    public function analyze()
    {

        $analysis = $this->analyzer->getAnalysis();

        return view('stats.analysis',['analysis' => $analysis]);

    }

    public function reset()
    {
        $this->analyzer->resetAll();

        return $this->index();
    }


}