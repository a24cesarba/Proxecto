import http from 'k6/http';

export const options = {
  stages: [
    { duration: '10s', target: 1 },
    { duration: '10m', target: 2 },
    { duration: '10m', target: 3 },
    { duration: '1m', target: 3 },
    { duration: '10m', target: 3 },
  ],
};

export default function () {
  http.get('http://192.168.1.139/testapp.php');
}