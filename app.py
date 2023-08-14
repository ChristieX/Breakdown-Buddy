from flask import Flask,request
import json
from flask_cors import CORS

app =Flask(__name__)
cors =CORS(app)
DB=[]
@app.route('/StoreDB',methods=['POST'])
def StoreDB():
    Fullname=request.json.get('Fullname')
    DOB=request.json.get('DOB')
    # print(Fullname)
    # print(DOB)
    DB.append({
        'FullName':Fullname,
        'DOB':DOB

    })
    with open('data.json','w') as f:
        json.dump(DB,f)
    print(DB)
    
    return json.dumps({'resp':'Pass'})

@app.route('/ReadDB')
def ReadDB():
    with open('data.json','r') as f:
        DB=json.load(f)
    print(DB)
    
    return json.dumps(DB)

if __name__ == '__main__':
    app.run(port=3000,debug=True)