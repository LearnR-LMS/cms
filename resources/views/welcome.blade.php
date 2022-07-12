<!-- welcome.blade.php -->

<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="example"></div>
    <pre id="json"></pre>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        window.onload = async () => {
            console.log('start request add halo testnet');
            if (!window.keplr) {
                alert('Please install Coin98 extension')
                return
            }
            await window['keplr'].experimentalSuggestChain({
                chainId: "halo-testnet-001",
                chainName: "Aura halo TestNet",
                rpc: "https://rpc.halo.aura.network",
                rest: "https://lcd.halo.aura.network",
                bip44: {
                    coinType: 118,
                },
                bech32Config: {
                    bech32PrefixAccAddr: "aura",
                    bech32PrefixAccPub: "aura" + "pub",
                    bech32PrefixValAddr: "aura" + "valoper",
                    bech32PrefixValPub: "aura" + "valoperpub",
                    bech32PrefixConsAddr: "aura" + "valcons",
                    bech32PrefixConsPub: "aura" + "valconspub",
                },
                currencies: [{
                    coinDenom: "AURA",
                    coinMinimalDenom: "uaura",
                    coinDecimals: 6,
                    // coinGeckoId: "aura",
                }, ],
                feeCurrencies: [{
                    coinDenom: "AURA",
                    coinMinimalDenom: "uaura",
                    coinDecimals: 6,
                    // coinGeckoId: "uaura",
                }, ],
                stakeCurrency: {
                    coinDenom: "AURA",
                    coinMinimalDenom: "uaura",
                    coinDecimals: 6,
                    // coinGeckoId: "uaura",
                },
                coinType: 118,
                gasPriceStep: {
                    low: 0.001,
                    average: 0.0025,
                    high: 0.004
                },
                features: ['no-legacy-stdTx'],
                walletUrlForStaking: "https://halo.aurascan.io/validators",
                logo: "https://i.imgur.com/zi0mTYb.png",
                explorer: "https://halo.aurascan.io/"
            });
            const account = (await window.getOfflineSigner('halo-testnet-001').getAccounts())[0]
            const preTag = document.getElementById('json')
            preTag.textContent = JSON.stringify({
                address: account.address
            }, undefined, 2)
            console.log('finish request add halo testnet');

            axios.delete("{{env('APP_URL')}}/api/transfer/course/123")
            .then(response => {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error)
            })
        }
    </script>
</body>

</html>