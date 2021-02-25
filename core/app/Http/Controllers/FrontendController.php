<?php

namespace App\Http\Controllers;

use App\BuyMoney;
use App\Category;
use App\Continent;
use App\Country;
use App\Currency;
use App\ExchangeMoney;
use App\Faq;
use App\GeneralSettings;
use App\Mentor;
use App\Menu;
use App\Post;
use App\SellMoney;
use App\Service;
use App\Subscriber;
use App\Testimonial;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Home";
        $data['currency'] = Currency::whereStatus(1)->orderBy('symbol','asc')->get();
        $data['currency2'] = Currency::whereStatus(1)->orderBy('symbol','desc')->get();
        $data['testimonial'] = Testimonial::all();
        $data['service'] = Service::all();
        $data['exchange'] = ExchangeMoney::where('status',2)->latest()->take(10)->get();
        $data['sellMoney'] = SellMoney::where('status',2)->latest()->take(10)->get();
        $data['buyMoney'] = BuyMoney::where('status',2)->latest()->take(10)->get();
        $data['service'] = Service::all();
        return view('front.home', $data);
    }

    public function blog()
    {
        $data['page_title'] = "News";
        $data['blogs'] = Post::where('status', 1)->latest()->paginate(3);
        return view('front.blog', $data);
    }

    public function blogData() {
        if(request("category") == null) return json_encode(array('errors' => 'Parameter Error'));

        $url = 'https://cryptonews-api.com/api/v1' . request("category");

        $param = array(
            "token" => env('CRYPTO_API_TOKEN'),
            "source" => "Bitcoin/samp>,Bloomberg+Markets+and+Finance,Bloomberg+Technology,Coindesk,CoinMarketCap,CryptoNinjas,CryptoTicker,Decrypt,Forbes,Fox+Business,NewsBTC,Reuters,The+Daily+Hodl,Yahoo+Finance",
            "type" => "article",
            "topicOR" => "Digital+Dollar,Digital+Euro,Futures,Mining,Stablecoins,Tanalysis,Taxes,Upgrade,Whales",
            "sortby" => "rank",
            "fallback" => "true",
            "items" => "5",
            "page" => 1
        );

        if(request("page") != NULL) $param["page"] = request("page");
        if(request("date") != NULL) $param["date"] = request("date");
        if(request("topic") != NULL) $param["topicOR"] = request("topic");
        //if(request("search") != NULL) $param["search"] = request("search");
        if(request("sentiment") != NULL) $param["sentiment"] = request("sentiment");

        foreach($param as $key => $value) $url .= "&" . $key . "=" . $value;

        $result = file_get_contents($url);
        return $result;
    }

    public function categoryByBlog($id)
    {
        $cat = Category::find($id);
        $data['page_title'] = "$cat->name";
        $data['blogs'] = $cat->posts()->latest()->paginate(3);
        return view('front.blog', $data);
    }

    public function details($id)
    {
        $post = Post::find($id);
        if ($post) {
            $data['page_title'] = "Blog Details";
            $data['post'] = $post;
            return view('front.details', $data);
        }
        abort(404);
    }

    public function faqs()
    {
        $data['page_title'] = "Faq";
        $data['faqs'] = Faq::all();
        return view('front.faq', $data);
    }
    public function termsCondition()
    {
        $data['page_title'] = "Terms & Condition";

        return view('front.terms', $data);
    }
    public function privacyPolicy()
    {
        $data['page_title'] = "Privacy & Policy";
        return view('front.policy', $data);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);
        $macCount = Subscriber::where('email', $request->email)->count();
        if ($macCount > 0) {
            return back()->with('alert', 'This Email Already Exist !!');
        } else {
            Subscriber::create($request->all());
            return back()->with('success', ' Subscribe Successfully!');
        }
    }

    public function contactUs()
    {
        $data['page_title'] = "Contact Us";
        return view('front.contact', $data);
    }

    public function contactSubmit(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
            'subject' => 'required',
            'phone' => 'required',
        ]);
        $subject = $request->subject;
        $phone = "<br><br>" . "Contact Number : " . $request->phone . "<br><br>";

        $txt = $request->message . $phone;

        send_contact($request->email, $request->name, $subject, $txt);
        return back()->with('success', ' Contact Message Send Successfully!');
    }

    public function about()
    {
        $data['page_title'] = "About Us";
        $data['mentors'] = Mentor::all();
        $data['service'] = Service::all();
        return view('front.about', $data);
    }

    public function service($id)
    {
        $service = Service::find($id);
        if ($service) {
            $get['data'] = $service;
            $get['page_title'] = "Service";
            return view('front.service-info', $get);
        }
        abort(404);
    }

    public function menu($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            $data['page_title'] = $menu->name;
            $data['menu'] = $menu;
            return view('front.menu', $data);
        }
        abort(404);
    }

    public function mining()
    {
        $get['currency'] = Currency::whereStatus(1)->orderBy('name','asc')->get();
        $get['page_title'] = " Buy Currency";
        return view('front.mining', $get);
    }

    public function exchange()
    {
        $get['currency'] = Currency::whereStatus(1)->orderBy('symbol','asc')->get();
        $get['currency2'] = Currency::whereStatus(1)->orderBy('symbol','desc')->get();
        $get['testimonial'] = Testimonial::all();
        $get['service'] = Service::all();
        $get['exchange'] = ExchangeMoney::where('status',2)->latest()->take(10)->get();
        $get['sellMoney'] = SellMoney::where('status',2)->latest()->take(10)->get();
        $get['buyMoney'] = BuyMoney::where('status',2)->latest()->take(10)->get();
        $get['service'] = Service::all();
        $get['page_title'] = " Exchange Currency";
        return view('front.exchange', $get);
    }

    public function buy()
    {
        $get['currency'] = Currency::whereStatus(1)->orderBy('name','asc')->get();
        $get['page_title'] = " Buy Currency";
        return view('front.buy', $get);
    }
    public function sell()
    {
        $get['page_title'] = "Sell Currency";
        $get['currency'] = Currency::whereStatus(1)->orderBy('name','asc')->get();
        return view('front.sell', $get);
    }

    public function register($reference)
    {
        $page_title = "Sign Up";
        return view('auth.register',compact('reference','page_title'));
    }




    public function cronPrice()
    {
        $coins = Currency::where('is_coin', 1)->where('status',1)->get();
        foreach ($coins as $coin) {
            $a = file_get_contents("https://min-api.cryptocompare.com/data/pricemultifull?fsyms=USD&tsyms=$coin->symbol");
            $b = json_decode($a, true);

            if (isset($b['Type']) == 1) {
                continue;
            } else {
                $raw = $b['RAW']['USD']["$coin->symbol"];
                $coin['price'] = round($raw['PRICE'], 8);
                $coin->save();
            }
        }


    }


}
