using RestSharp;
using RestSharp.Serialization.Json;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace ExitAppTerminal
{
    public partial class Form1 : Form
    {
        static String serverIp = "http://192.168.31.33/API/parking/skuds/";
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int pId = int.Parse(textBox1.Text);
            String carNum = textBox2.Text;

            var client = new RestClient(serverIp);
            // client.Authenticator = new HttpBasicAuthenticator(username, password);
            var request = new RestRequest("open.php");
            request.RequestFormat = DataFormat.Json;
            request.AddBody(new { id = pId, carNumber = carNum });
            var response = client.Post(request);
            var responseEvent = new JsonDeserializer().Deserialize<ResponseEvent>(response);

            MessageBox.Show(responseEvent.message, "Info Message", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);

            textBox2.Text = "";
        }
    }

    public class ResponseEvent
    {
        public string message { get; set; }
    }
}
