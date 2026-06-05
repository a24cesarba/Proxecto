import http from 'k6/http';

export const options = {
  stages: [
    { duration: '10s', target: 100 },
    { duration: '10s', target: 500 },
    { duration: '10s', target: 1000 },
    { duration: '1m', target: 1000 },
    { duration: '10m', target: 1500 },
  ],
};

export default function () {
  http.get('http://192.168.1.139/login.php');
}