\debug code
#include<iostream>
using namespace std;
char* subset(char* str1,char* str2)
{
    int m=0,n=0,i,j;
    while(str1[m]!='\0')
        ++m;
    while(str2[n]!='\0')
        ++n;
    int lcs[10][10];
    for(i=0;i<=m;i++)
    {
        for(j=0;j<=n;j++)
        {
            if(i==0||j==0)
                {lcs[i][j]=0;}
            else if(str1[i]==str2[j])
                lcs[i][j]=lcs[i-1][j-1];
            else
                lcs[i][j]=max(lcs[i-1][j],lcs[i][j-1]);
    }
    }
    int lcs_len= lcs[m][n];
    char* result=new char[lcs_len+1];
    i=m;j=n;
    while(i>0 && j>0)
    {
        if(str1[i-1]==str2[j-1])
            {
                result[lcs_len-1]=str1[i-1];
                i--;
                j--;
                lcs_len--;
            }
        else if(lcs[i-1][j]>lcs[i][j-1])
            i--;
        else
            j--;
    }
    return result;
}
int main()
{
    char* lcs;
    char str1[20],str2[20];
    cout<<"Enter first string: ";
    cin.getline(str1,20);
    cout<<"Enter second string: ";
    cin.getline(str2,20);
    lcs=subset(str1,str2);
    cout<<"longrest common subsequence: "<<lcs;
    return 0;
}

